<?php

namespace App\Exports;

use App\Models\Demande;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


class DemandeRepoortExport implements FromView
{
    use Exportable;
    protected $tableau;

    function __construct( $tableau) {
        $this->tableau = $tableau;
    }

    public function view(): View
    {
        // dd($this->tableau, $this->tableau->item->data->date[1]);
        if($this->tableau->item->type_rapport == 'Demande') {
            return view('/rapport/demande', [
                'data' => $this->tableau,
            ]);
        }elseif($this->tableau->item->type_rapport == 'Autorisations'){
            return view('/rapport/autorisation', [
                'data' => $this->tableau,
            ]);
        }
    }
}
