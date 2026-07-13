<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\CarteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/carte/scanner', [CarteController::class,'scanner'])->name('carte.scanner');

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();
    if ($user) {
        if ($user->statut == 1) {
            if (Hash::check($request->password, $user->password)) {
                Auth::attempt(['email' => $request->email, 'password' => $request->password]);
                $auth = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                return  ['code' => 2, 'message' => 'Vous etes connecté', 'user' => $auth, 'token' => $token];
            } else {
                return ['code' => 1, 'message' => 'votre mot de passe est incorecte'];
            }
        } else {
            return ['code' => 0, 'message' => 'Votre compte n\'est pas actif veuillez contacter l\'administrateur'];
        }
    } else {
        return ['code' => 3, 'message' => 'Votre identifiant n\'est pas correcte'];
    }
});
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Déconnecté avec succès'], 200);
});
Route::get('/getNumAutorisation', [APIController::class, 'getNumAutorisation']);
// Route::middleware('auth:sanctum')->get('/getNumAutorisation', [APIController::class, 'getNumAutorisation']);
Route::middleware('auth:sanctum')->post('/store/redevances', [APIController::class, 'store']);
Route::middleware('auth:sanctum')->get('/index/redevances', [APIController::class, 'index']);
Route::middleware('auth:sanctum')->get('/facture/redevances/{id}', [APIController::class, 'facture']);
Route::middleware('auth:sanctum')->post('/payement/redevances', [APIController::class, 'payement']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::get('employee', [EmployeeController::class, 'index']);
});
