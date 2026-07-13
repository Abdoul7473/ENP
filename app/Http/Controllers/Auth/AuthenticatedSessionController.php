<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // if($)
        // if($request){
        //     $check = 0;
        //     $verif = User::where('email', $request->email)->first(); 
        //     // dd($verif);
        //     if($verif){
        //         if($verif->statut == 1){
        //             if (Hash::check($request->password, $verif->password)) {
        //                 $check = 1;
        //             }
        //             if ($check == 0) {
        //                 return redirect()->back()->with('error',"Votre mot de passe est incorrect");
        //             }  
        //             if ($verif->first_login == 1){
        //                 if ($verif->postulant_id != null) {
        //                     $request->authenticate();
        //                     $request->session()->regenerate();
        //                     return redirect()->intended(RouteServiceProvider::POSTULANT);
        //                 } else {
        //                     $request->authenticate();
        //                     $request->session()->regenerate();
        //                     return redirect()->intended(RouteServiceProvider::HOME);
        //                 }
        //             }else{
        //                 return redirect()->route('change_password',$verif->id);
        //             }
        //         }else{
        //             return redirect()->back()->with('error',"Votre compte n'est pas actif, Merci de contacter l'Administrateur");
        //         }
        //     }else{
        //         return redirect()->back()->with('error',"Votre identifiant est incorrect");
        //     }
        // }
        // $request->validateRecaptcha(); // Vérifie le reCAPTCHA

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', "Votre identifiant est incorrect");
        }

        if ($user->statut != 1) {
            return redirect()->back()->with('error', "Votre compte n'est pas actif, Merci de contacter l'Administrateur");
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', "Votre mot de passe est incorrect");
        }

        if ($user->first_login == 1) {
            $request->authenticate();
            $request->session()->regenerate();

            return redirect()->intended($user->postulant_id ? RouteServiceProvider::POSTULANT : RouteServiceProvider::HOME);
        }

        return redirect()->route('change_password', $user->id);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}