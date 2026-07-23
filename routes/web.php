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
    Route::get('/compagnie/index', [CompagnieContoller::class, 'index'])->name('compagnie.index');
    Route::post('/compagnie/store', [CompagnieContoller::class, 'store'])->name('compagnie.store');
    Route::get('/annee/index', [CompagnieContoller::class, 'index_annee'])->name('annee.index');
    Route::post('/annee/store', [CompagnieContoller::class, 'store_annee'])->name('annee.store');
    Route::post('/annee/cloture', [CompagnieContoller::class, 'cloture_annee'])->name('annee.cloture');

    Route::get('/encadreur/index', [CompagnieContoller::class, 'encadreur_index'])->name('encadreur.index');
    Route::get('/encadreur/create', [CompagnieContoller::class, 'encadreur_create'])->name('encadreur.create');
    Route::post('/encadreur/store', [CompagnieContoller::class, 'encadreur_store'])->name('encadreur.store');

    Route::get('/eleve/index/{id}', [EleveController::class, 'index'])->name('eleve.index');
    Route::get('/eleve/edit/{id}', [EleveController::class, 'edit'])->name('eleve.edit');
    Route::post('/eleve/import', [EleveController::class, 'import'])->name('eleve.import');
    Route::post('/eleve/update', [EleveController::class, 'update'])->name('eleve.update');
    
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
    Route::get('/rapport/pdf', [RapportController::class, 'GeneratePDF'])->name('rapport.pdf');
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
