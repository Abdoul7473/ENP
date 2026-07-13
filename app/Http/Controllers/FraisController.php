<?php

namespace App\Http\Controllers;

use App\Models\Frai;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FraisController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = Frai::when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where(function ($query) use ($value) {
                    $query->where('montant', 'LIKE', '%'.$value.'%');
                });
            })
            ->paginate($request->page_size ?? 16);
        return Inertia::render('frais/index', [
            'frais' => $data,
        ]);
    }



    public function store(Request $request)
    {
        $frais=Frai::find($request->id);
       $montant = str_replace([' ', ','], '', (string) $request->montant);
       $test= $frais->update(['montant'=>$montant]);
       if($test){
            return redirect()->back()->with('success','la modification a été faite avec success!');

        }else {
            return redirect()->back()->with('error', 'erreur de la modification veuillez ressayer');
        }

    }

}
