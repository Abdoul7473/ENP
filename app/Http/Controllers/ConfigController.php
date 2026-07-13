<?php

namespace App\Http\Controllers;

use App\Models\Aeroport;
use App\Models\AeroportConfig;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->user());
        $data = AeroportConfig::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->when($request->search, function ($query, $value) {
                $query->where('aeroport.libelle', 'LIKE', '%' . $value . '%');
            })->with("aeroport")
            ->paginate($request->page_size ?? 10);
        $aeroports = Aeroport::all();
        return Inertia::render("aeroports/configs", [
           "config_aeroports" => $data,
           "aeroports" => $aeroports
        ]);
    }
    public function store (Request $request){
        $request->validate([
            'aeroport' => ['required'],
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
        ]);
        foreach ($request->aeroport as $key => $aeroport) {
            if (AeroportConfig::where('aeroport_id',$aeroport)->exists()){
                
            }else {
                AeroportConfig::create([
                    "aeroport_id" => $aeroport
                ]);
            }
        }
        return redirect()->back()->with('success','aeroports enregistrer avec succès');
    }
    public function destroy (Request $request,$id){
        $config = AeroportConfig::find($id);
        $config->delete();
        return redirect()->back()->with('success','aeroport supprimé avec succès');
    }
}
