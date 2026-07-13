<?php

namespace App\Http\Controllers;

use App\Imports\ImportFichier;
use App\Models\Aeronef;
use App\Models\Aeroport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AeroportController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = Aeroport::when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where(function ($query) use ($value) {
                    $query->where('code_iata', 'LIKE', '%'.$value.'%')
                            ->orWhere('code_icao', 'LIKE', '%'.$value.'%')
                            ->orWhere('region', 'LIKE', '%'.$value.'%')
                            ->orWhere('nom', 'LIKE', '%'.$value.'%')
                            ->orWhere('pays', 'LIKE', '%'.$value.'%')
                            ->orWhere('libelle', 'LIKE', '%'.$value.'%');
                });
            })
            ->paginate($request->page_size ?? 15);
        return Inertia::render('aeroports/index', [
            'aeroports' => $data,
        ]);
    }



    public function store(Request $request)
    {
        // dd($request->fichier);
        if($request->importation==true && $request->file('fichier')!=null){
            $fichier = $request->file('fichier');
            // dd($fichier->getClientOriginalName());
            $data = Excel::toArray(new ImportFichier(), $fichier);
            if (count($data) > 0) {
                array_shift($data[0]);
            }else {
                # code...
                return redirect()->back()->with('error', 'Votre ficchier excel est vide, veuillez remplir');
            }

            if (count($data) > 0) {
                foreach ($data[0] as $key => $value) {
                    # code..
                    if ($value[0] != '' &&  $value[1] != '') {
                        Aeroport::create( [
                            'nom'=>$value[0],
                            'region'=>$value[3],
                            'code_iata'=>$value[2],
                            'code_icao'=>$value[1],
                            'pays'=>$value[4],
                        ] );
                    }
                    // dd($value);
                }
                return redirect()->back()->with('success','l\'enregistrement a été faite avec success!');
            }else {
                # code...
                return redirect()->back()->with('error', 'Votre ficchier excel est vide, veuillez remplir');
            }

        }else {
            if ($request->nom !='' &&  $request->code_iata != '') {
                # code...
                Aeroport::create( [
                    'nom'=>$request->nom,
                    'code_icao'=>$request->code_icao,
                    'region'=>$request->region,
                    'code_iata'=>$request->code_iata,
                    'pays'=>$request->pays,
                ] );
                return redirect()->back()->with('success','l\'enregistrement a été faite avec success!');
            }else {
                # code...
                return redirect()->back()->with('error', 'veuillez remplir les champs vide');
            }

        }

    }
    public function update(Request $request, $id)
    {
        //
        $aeroport=Aeroport::find($id);
        $check=$aeroport->update( [
            'nom'=>$request->nom,
            'code_icao'=>$request->code_icao,
            'region'=>$request->region,
            'code_iata'=>$request->code_iata,
            'pays'=>$request->pays,
        ] );
        if($check){
            return redirect()->back()->with('success','la modification a été faite avec success!');

        }else {
            return redirect()->back()->with('error', 'erreur de la modification veuillez ressayer');
        }
        // dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // dd($id);
        $aeroport=Aeroport::find($id);
        $aeroport->delete();
        return redirect()->back()->with('success', 'la suppression a été faite avec succès');
    }
}
