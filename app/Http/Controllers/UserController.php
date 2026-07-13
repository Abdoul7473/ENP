<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Ville;
use App\Models\Demande;
use App\Models\TypeUser;
use App\Models\Postulant;
use App\Models\TermsDocument;
use App\Models\VirtualAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use App\Mail\SampleMail;
use App\Jobs\SendEmailJob;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->user());
        $data_user = User::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->where('postulant_id', '=', null)
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })->with("type_user")
            ->paginate($request->page_size ?? 10);
        $data_postulant = User::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->where('postulant_id', '<>', null)
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })->with("postulant")
            ->paginate($request->page_size ?? 10);
        $demandes = Demande::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
            })->when($request->search, function ($query, $value) {
            $query->where(function ($inner) use ($value) {
                $inner->where('id', 'LIKE', '%' . $value . '%')
                    ->orWhereHas('user', function ($q) use ($value) {
                        $q->where('email', 'LIKE', '%' . $value . '%');
                    })
                    ->orWhereHas('user.postulant', function ($q) use ($value) {
                        $q->where('nom_raison_sociale', 'LIKE', '%' . $value . '%');
                    });
            });
            })->with("routes","user.postulant","statut","user_autoriser","user_appro","user_verif","aeronefs","type_demande")
            ->paginate($request->page_size ?? 10);
        return Inertia::render("user/index", [
            "users" => $data_user,
            "user_postulant" => $data_postulant,
            "demandes"=>$demandes,
        ]);
    }
    public function store(Request $request)
    {
        $gmtDate = Carbon::now('GMT');
        $request->validate([
            'nom_raison_sociale' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'tel' => ['required'],
            'fichier'  => $request->check  ? 'required' : '',
            'pay_id' => ['required'],
            'ville_id' => ['required'],
            'accept_cgu' => ['accepted'],
            'accept_deposit' => ['accepted'],
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
            'accept_cgu.accepted' => 'Veuillez accepter les conditions générales d\'utilisation.',
            'accept_deposit.accepted' => 'Veuillez accepter les conditions de dépôt.',
        ]);

        $type_postulant = null;
        $nom_fichier = null;
        // dd($request->fichier);
        if ($request->check) {
            $type_postulant = 2;
            // dd($request->file('fichier'));
            $request->file('fichier')->move('documents/operateurs/', $request->file('fichier')->getClientOriginalName());
            $nom_fichier = $request->file('fichier')->getClientOriginalName();
            // dd($nom_fichier);
        } else {
            $type_postulant = 1;
        }
        try {
            $user_exit = User::where('email', $request->email)->first();
            // dd($user_exit);
            if ($user_exit && $user_exit->exists()) {
                return redirect()->back()->with('error', 'Cet E-mail existe déjâ!!');
            } else {
                // dd($request->all());
                $postulant = Postulant::create([
                    "nom_raison_sociale" => $request->nom_raison_sociale,
                    "tel" => $request->tel,
                    "tel2" => $request->tel2,
                    "adresse" => $request->adresse,
                    "fonction" => $request->fonction,
                    "type_postulant_id" => $type_postulant,
                    "fichier" => $nom_fichier,
                    "ville_id" => $request->ville_id
                ]);
              
                $postulant->numero_ordre = $gmtDate->format('Y') . "_" . $postulant->id;
                $postulant->save();
                $type_user = TypeUser::where('libelle', 'Postulant')->get();
                $user = User::create([
                    'name' => 'Postulant',
                    'email' => $request->email,
                    'password' => Hash::make('password'),
                    'postulant_id' => $postulant->id,
                    'type_user_id' => $type_user[0]->id,
                ]);
                $postulant_rol = Role::updateOrCreate(['name' => 'Postulant']);
                $postulant_rol->givePermissionTo(Permission::where('name', 'postulant'));
                $user->assignRole($postulant_rol);   
                
                // creer un compte virtuel à la création d'un postulant
                $virtualAccount = VirtualAccount::create(['user_id' => $user->id]);
                
                $url = 'https://www.google.com';
                $headers = @get_headers($url);
                if ($headers && strpos($headers[0], '200') !== false) {
                    $contenu = "Votre compte a été crée avec succès veuillez attendre que l\'administrateur active votre compte \n Your account has been successfully created, please wait for the administrator to activate your account ";
                    $donnees = [
                        'subject' => 'Création du compte',
                        'email' => $request->email,
                        'contenu' => $contenu,
                        'type' => 1
                    ];
                    dispatch(new SendEmailJob($donnees));
                }          
                return redirect()->back()->with('success', 'Création effectué avec succes!!');
                // return redirect()->route('/page')->with('success', 'Votre compte a été crée avec succès. Vous aurez un message sur votre boîte mail');
            }
        } catch (\Throwable $th) {
            \Log::error('Erreur lors de la création du compte : ' . $th->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du compte.');
        }
    }

    public function active(Request $request)
    {
        // dd($request->all());
        $user = User::find($request->id);
        $user->statut = 1;
        $url = 'https://www.google.com';
        $headers = @get_headers($url);
        if ($headers && strpos($headers[0], '200') !== false) {
            $user->update();
            $contenu = "Votre compte a été activé veuillez vous connecté avec LOGIN: votre E-mail et Mot de passe : password \n Your account has been activated, please log in with LOGIN: your Email and Password: password";
            $donnees = [
                'subject' => 'Activation du compte',
                'email' => $user->email,
                'contenu' => $contenu,
                'type' => 1
            ];
            dispatch(new SendEmailJob($donnees));
        return redirect()->back()->with('success', "Le compte a été activé success!");
        }else {
            return redirect()->back()->with('error', "Le compte n'a pas été activé probleme de connexion veuillez réessayer!");
        }
    }
    public function desactive(Request $request)
    {
        $user = User::find($request->id);
        $user->statut = 0;
        $user->update();
        return redirect()->back()->with('success', "Le compte a été désativé avec succès!");
    }
    public function terme(Request $request)
    {
        // dd($request->all());
        $user = User::find($request->id);
        $user->terme = $request->type;
        $user->update();
        return redirect()->back()->with('success', "Le compte a été modifié avec succès!");
    }
    public function create(Request $request)
    {
        return Inertia::render('user/create', [
            "roles" => Role::all(),
            "types" => TypeUser::where('libelle', '<>', 'Postulant')->get(),
        ]);
    }
    public function store_user_system(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'type' => 'required'
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        ]);
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Cet E-mail existe déjâ');
        } else {
            $user = User::create([
                'name' => $request->nom . ' ' . $request->prenom,
                'email' => $request->email,
                'password' => Hash::make("password"),
                'type_user_id' => $request->type,
                'statut' => 1
            ]);
            $permis = Role::find($request->role);
            $user->syncRoles($request->role);
            $user->syncPermissions($permis->permissions->pluck('id'));
            return redirect()->route('user.index')->with('success', 'Compte a été crée avec succès');
        }
    }
    public function edit(Request $request,$id){
        // dd($id);
        return Inertia::render('user/update', [
            "user" => User::with('roles')->where('id',$id)->get()[0],
            "roles" => Role::all(),
            "types" => TypeUser::where('libelle', '<>', 'Postulant')->get(),
        ]);
    }
    public function update(Request $request,$id){
        $user = User::find($id);
        $user->type_user_id = $request->type;
        $user->name = $request->nom;
        $user->email = $request->email;
        $user->update();
        $user->syncRoles($request->role);
        $permis = Role::find($request->role);
        $user->syncPermissions($permis->permissions->pluck('id'));
        return redirect()->route('user.index')->with('success', 'Compte a été modifié avec succès');
    }
    public function destroy(Request $request,$id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Compte a été supprimé avec succès');
    }
    public function ChangePassword($id){
        return Inertia::render('user/change',[
            'id' => $id
        ]);
    }
   
    public function ChangePasswordStore(Request $request){
        $user = $request->id ? User::find($request->id) : Auth::user();
        // dd($user);
        $request->validate([
            'old_password'=> 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        ]);
    
        
        if (Hash::check($request->old_password,$user->password)){
            if ($request->password == $request->password_confirmation) {
            $user->password = Hash::make($request->password);
            $user->first_login = 1;
            $user->save();
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect()->route('connexionpage')->with('success', 'Votre mot de passe a été mis à jour avec succès');
            } else {
                return redirect()->back()->with('error', "Vos deux mot de passe ne correspondesnt pas!");
            }
        }else{
            return redirect()->back()->with('error', 'L\'ancien mot de passe est incorrect!');
        }
    }
    public function Detail(Request $request){
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        $docs = TermsDocument::all()->keyBy('type');
        $terms = [
            'cgu' => $docs->get('cgu') ? [
                'url' => '/documents/terms/' . $docs->get('cgu')->filename,
                'name' => $docs->get('cgu')->original_name,
                'mime' => $docs->get('cgu')->mime_type,
            ] : null,
            'deposit' => $docs->get('deposit') ? [
                'url' => '/documents/terms/' . $docs->get('deposit')->filename,
                'name' => $docs->get('deposit')->original_name,
                'mime' => $docs->get('deposit')->mime_type,
            ] : null,
        ];
        return Inertia::render('user/detail',[
            'user' => User::where('id',Auth::user()->id)->with('postulant','postulant.ville','postulant.type_postulant','postulant.ville.pay')->get()[0],
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
            'villes' => Ville::all(),
            'terms' => $terms,
        ]);
    }
    public function ModifiPostulant(Request $request){
        $request->validate([
            'email' => 'required|string',
            'name' => 'required|string',
            'ville' => 'required',
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        ]);
        $user = User::find($request->id);
        $user->email = $request->email;
        $user->update();
        $postulant = Postulant::find($user->postulant_id);
        $postulant->nom_raison_sociale = $request->name;
        $postulant->adresse = $request->adresse;
        $postulant->tel = $request->tel2;
        $postulant->tel2 = $request->tel;
        $postulant->fonction = $request->fonction;
        $postulant->ville_id = $request->ville;
        $postulant->update();
        return redirect()->back()->with('success','Vos informations ont été mis à jour avec succès');
    }
    public function ResetPassword(Request $request){
        $user = User::where('id',$request->id)->get()[0];
        $url = 'https://www.google.com';
        $headers = @get_headers($url);
        if ($headers && strpos($headers[0], '200') !== false) {
            $user->password = Hash::make('password');
            $user->first_login = 0;
            $user->save();
            $destinataire = $user->email;
            $sujet = 'Information';
            $donnees = [
                'subject' => 'Reinitialisation du compte',
                'email' => $destinataire,
                'contenu' => "Votre mot de passe a été réinitialisé Merci de vous connecter avec LOGIN: votre E-mail et Mot de passe : password, pour pouvoir configurer à nouveau votre nouveau mot de passe \n Your password has been reset Please log in with LOGIN: your Email and Password: password, to be able to configure your new password again",
                'type' => 1
            ];
            dispatch(new SendEmailJob($donnees));
            return redirect()->back()->with('success','Mot de passe réinitialisé avec succès');
        } else {
            return redirect()->back()->with('error','Mot de passe n\'a été réinitialisé probleme de connexion veuillez réessayer!');
        } 
    }
    public function reset_password(){
        $user = Auth::user();
        if ($user->postulant_id !== null){
            $demandes = Demande::where('user_id',Auth::user()->id);
            $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
            $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
            $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
            $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
            return Inertia::render('user/resetPasswordPostulant',[
                'nbre_annule' => $demandes_annulees->count(),
                'nbre_renvoi' => $demandes_renvoyees->count(),
                'nbre_rejet' => $demandes_rejetees->count(),
                'nbre_auto' => $demandes_autorisees->count(),
                'nbre_demandes' => $demandes->count(),
            ]);    
        }else{
            return Inertia::render('user/resetPassword');

        }
    }
}
