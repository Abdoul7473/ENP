<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use App\Models\Ville;
use App\Models\TermsDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
    public function __construct() {
        $this->middleware('auth')->only('index');
    }

    public function index() {
        $nbr_personne_grade = NbrPersonnelParGrade();
        $nbr_eleve_corp = NbrEleveParCorp();
        return Inertia::render( 'home', [
            'nbr_personne_grade' => $nbr_personne_grade,
            'nbr_eleve_corp' => $nbr_eleve_corp
        ] );
    }

   

    public function connexionpage( Request $request ) {
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
