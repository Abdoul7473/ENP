<?php

use App\Models\User;
use Inertia\Inertia;
use App\Models\Route as ModelsRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompagnieContoller;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SituationController;
use App\Http\Controllers\HomeConcontentTypetroller;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EnseignementController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RapportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()){
        if (Auth::user()->postulant_id != null) {
            return redirect()->intended(RouteServiceProvider::POSTULANT);
        } else {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }else{
        return Inertia::render('welcome');
    }
})->name('/');

Route::get('/change_password/2343uyfkklj43{id}6_uygu_uihGHJhuIKJK_yh5454',[UserController::class,'ChangePassword'])->name('change_password');
Route::post('/change_password',[UserController::class,'ChangePasswordStore'])->name('change_password_store');


Route::middleware(['auth'])->group(function () {
    Route::get('/carte/index', [CarteController::class, 'index'])->name('carte.index');
    Route::post('/carte/store', [CarteController::class, 'store'])->name('carte.store');
    Route::get('/carte/pdf', [CarteController::class,'generateCartePdf'])->name('carte.pdf');

    Route::get('/carte/invitation/pdf/{id}', [CarteController::class,'generateInvitationPdf'])->name('invitation.pdf');
    
    Route::get('/carte/detail/{id}', [CarteController::class, 'detail'])->name('carte.detail');
    Route::get('/visiteurs/index', [VisiteurController::class, 'index'])->name('visiteurs.index');
    Route::get('/visiteurs/create', [VisiteurController::class, 'create'])->name('visiteurs.create');
    Route::post('/visiteurs/store', [VisiteurController::class, 'store'])->name('visiteurs.store');
    Route::post('/visiteurs/notifier', [VisiteurController::class, 'notifier'])->name('visiteur.notifier');
    Route::get('/compagnie/index', [CompagnieContoller::class, 'index'])->name('compagnie.index');
    Route::post('/compagnie/store', [CompagnieContoller::class, 'store'])->name('compagnie.store');
    Route::get('/annee/index', [CompagnieContoller::class, 'index_annee'])->name('annee.index');
    Route::post('/annee/store', [CompagnieContoller::class, 'store_annee'])->name('annee.store');
    Route::post('/annee/cloture', [CompagnieContoller::class, 'cloture_annee'])->name('annee.cloture');

    Route::get('/entite/index', [CompagnieContoller::class, 'entite_index'])->name('entite.index');
    Route::post('/entite/store', [CompagnieContoller::class, 'entite_store'])->name('entite.store');

    Route::get('/encadreur/index', [CompagnieContoller::class, 'encadreur_index'])->name('encadreur.index');
    Route::get('/encadreur/create', [CompagnieContoller::class, 'encadreur_create'])->name('encadreur.create');
    Route::post('/encadreur/store', [CompagnieContoller::class, 'encadreur_store'])->name('encadreur.store');

    Route::get('/eleve/index/{id}', [EleveController::class, 'index'])->name('eleve.index');
    Route::get('/eleve/edit/{id}', [EleveController::class, 'edit'])->name('eleve.edit');
    Route::post('/eleve/import', [EleveController::class, 'import'])->name('eleve.import');
    Route::post('/eleve/update', [EleveController::class, 'update'])->name('eleve.update');
    Route::post('/eleve/inputFile', [EleveController::class, 'inputFile'])->name('eleve.input_file');
    Route::post('/eleve/updateStatus', [EleveController::class, 'updateStatus'])->name('eleve.updateStatus');
    
    Route::get('/situation/create/{id}', [SituationController::class, 'create'])->name('situation.create');
    Route::get('/situation/index/{id}', [SituationController::class, 'index'])->name('situation.index');
    Route::post('/situation/store', [SituationController::class, 'store'])->name('situation.store');

    Route::resource('roles', RoleController::class)->only(['index','update', 'create','store', 'destroy']);
    Route::resource('user', UserController::class)->only(['index','create', 'store','edit', 'update', 'destroy']);
    Route::post('roles/delete_permission', [RoleController::class, 'delete_permission'])->name('roles.delete_permission');
    Route::post('user/reset_password', [UserController::class, 'ResetPassword'])->name('user.reset_password');
    Route::post('roles/create_permission', [RoleController::class, 'create_permission'])->name('roles.create_permission');
    Route::post('/user/store_user_system', [UserController::class,'store_user_system'])->name('user.store_user_system');
    Route::post('/carte/cacher_signature', [CarteController::class,'ajout_signature'])->name('carte.signature');

    Route::resource('/rapport', RapportController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/rapport/query', [RapportController::class, 'Query'])->name('rapport.query');
    Route::get('/rapport/export', [RapportController::class, 'ExportExcel'])->name('rapport.export');
    Route::get('/rapport/pdf', [RapportController::class, 'GeneratePDF'])->name('rapport.pdf');

    Route::get('/permissionaire/index', [PermissionController::class, 'index'])->name('permissionnaire.index');
    Route::post('/permissionaire/store', [PermissionController::class, 'store'])->name('permissionnaire.store');
    Route::get('/permissionaire/pdf/{id}', [PermissionController::class, 'PermissionPdf'])->name('permissionnaire.pdf');

    Route::get('/matiere/index', [ModuleController::class, 'index'])->name('matiere.index');
    Route::post('/matiere/store', [ModuleController::class, 'store'])->name('matiere.store');

    Route::get('/corp/index', [ModuleController::class, 'corp_index'])->name('corp.index');

    Route::get('/groupe/index/{id}', [ModuleController::class, 'groupe_index'])->name('groupe.index');
    Route::post('/groupe/store', [ModuleController::class, 'groupe_store'])->name('groupe.store');

    Route::get('/module/index/{id}', [ModuleController::class, 'module_index'])->name('module.index');
    Route::post('/module/store', [ModuleController::class, 'module_store'])->name('module.store');

    Route::get('/enseignant/index', [ModuleController::class, 'enseignant_index'])->name('enseignant.index');
    Route::post('/enseignant/store', [ModuleController::class, 'enseignant_store'])->name('enseignant.store');

    Route::get('/enseignement/index/@à&é_è_{id}_é_é&à@', [EnseignementController::class, 'enseignement_index'])->name('enseignement.index');
    Route::post('/enseignement/store', [EnseignementController::class, 'enseignement_store'])->name('enseignement.store');

    Route::get('/avancement/index/@à&é_è_{id}_é_é&à@', [EnseignementController::class, 'avancement_index'])->name('avancement.index');
    Route::get('/avancement/create/@à&é_è_{id}_é_é&à@', [EnseignementController::class, 'avancement_create'])->name('avancement.create');
    Route::post('/avancement/store', [EnseignementController::class, 'avancement_store'])->name('avancement.store');

    Route::get('/evaluations/index/@à&é_è_{id}_é_é&à@', [EnseignementController::class, 'evaluation_index'])->name('evaluation.index');
    Route::post('/evaluation/store', [EnseignementController::class, 'evaluation_store'])->name('evaluation.store');

    Route::get('/note/index/@à&é_è_{id}_é_é&à@', [EnseignementController::class, 'note_index'])->name('note.index');
    Route::post('/note/store', [EnseignementController::class, 'note_store'])->name('note.store');

});



// Route::get('email-test', function(){

//     $details['email'] = 'nouri.ismael@yahoo.com';

//     dispatch(new App\Jobs\SendEmailJob($details));

//     dd('done');
// });
  Route::group(['middleware' => ['checkPermissions:manage_system']], function () {
        // Route::resource('roles', RoleController::class)->only(['index','update', 'create','store', 'destroy']);
        // Route::resource('email', EmailController::class)->only(['index','update', 'create','store', 'destroy']);
        // Route::resource('user', UserController::class)->only(['index','create', 'store','edit', 'update', 'destroy']);
        // Route::post('roles/delete_permission', [RoleController::class, 'delete_permission'])->name('roles.delete_permission');
        // Route::post('user/reset_password', [UserController::class, 'ResetPassword'])->name('user.reset_password');
        // Route::post('roles/create_permission', [RoleController::class, 'create_permission'])->name('roles.create_permission');
        // Route::resource('aeroports', AeroportController::class)->only(['index', 'store', 'update', 'destroy']);
        // Route::resource('configs', ConfigController::class)->only(['index', 'store', 'update', 'destroy']);
        // Route::get('terms', [TermsDocumentController::class, 'index'])->name('terms.index');
        // Route::post('terms', [TermsDocumentController::class, 'store'])->name('terms.store');
        // Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        // Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');
    });

Route::get('home', [HomeController::class, 'index'])->middleware('user.type')->name('home');
Route::get('page', [HomeController::class, 'connexionpage'])->name('connexionpage');
// Route::get('/qrcode', function () {
//     $numeros = ModelsRoute::distinct('num_autorisation')->pluck('num_autorisation')->toArray();
//     // dd($numeros);// Supposons que votre colonne s'appelle "numero"
//     // Formater les numéros avec chaque numéro sur une nouvelle ligne
//      // Formater les numéros avec "numero :" avant chaque numéro
//      $numerosString = "NUMEROS AUTORISATION \n" ;
//      $numerosString .= " - N° DG/ANAC-" . implode("\n - N° DG/ANAC-", $numeros);




// Route::resource('demandes', DemandeController::class);


Route::get('notFound', [RoleController::class, 'Not_found'])->name('NotFound');




require __DIR__ . '/auth.php';
