<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\Eleve;
use App\Imports\ElevesImport;
use App\Models\Annee;
use Maatwebsite\Excel\Facades\Excel;

class EleveController extends Controller
{
    public function index(Request $request, $id)
    {
        $eleves = Eleve::where('compagnie_id', $id)->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);
        return Inertia::render('Eleves/index', [
            'eleves' => $eleves,
            'id' => $id
        ]);
    }
    public function import(Request $request)
    {
        $data = Excel::import(new ElevesImport($request), $request->fichier,);

        return redirect()->back()->with('success', 'l\'enregistrement a été faite avec success!');
    }
    public function edit(Request $request, $id)
    {
        return Inertia::render('Eleves/edit', [
            'eleve' => Eleve::where('id', $id)->get()[0]
        ]);
    }
    public function update(Request $request)
    {
        $image = $request->photo;
        preg_match("/data:image\/(.*?);base64,/", $image, $extension);

        $extension = $extension[1];
        $image = preg_replace(
            "/^data:image\/\w+;base64,/",
            '',
            $image
        );
        $nom = str_replace(' ', '', $request->matricule . $request->nom . $request->prenom);
        $image = str_replace(' ', '', $image);

        $nom_fichier = $nom . '.' . $extension;

        file_put_contents(
            public_path('eleves/' . $nom_fichier),
            base64_decode($image)
        );
        $eleve = Eleve::where('id', $request->id)->get()[0];
        $eleve->nom = $request->nom;
        $eleve->prenom = $request->prenom;
        $eleve->date_naiss = $request->date_naiss;
        $eleve->lieu_naiss = $request->lieu_naiss;
        $eleve->sexe = $request->sexe;
        $eleve->tel = $request->tel;
        $eleve->groupe_sanguin = $request->groupe_sanguin;
        $eleve->photo = $nom_fichier;
        $eleve->update();
        return redirect()->route('eleve.index', $eleve->compagnie_id)->with('success',  'élève modifié avec success!');
    }
    public function inputFile(Request $request)
    {
        $eleves = Eleve::where('compagnie_id', $request->compagnie_id)->orderBy('id', 'asc')->get();
        // dd();
        $cpp = 0;
        foreach ($request->photos as $key => $value) {
            $cpp++;
        }
        foreach ($eleves as $key => $eleve) {
            if ($cpp > $key) {
                $photo = $request->photos[$key];
                $nomfichier = str_replace(' ', '', $eleve->matricule  . $eleve->prenom . $eleve->nom);
                $eleve->photo = $nomfichier;
                $eleve->update();
                $photo->move( 'eleves/', $nomfichier );
            }
        }
        return redirect()->back()->with('success', 'photos importées avec success!');
    }
}
