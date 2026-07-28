<?php

namespace App\Exports;

use App\Models\Demande;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


class RapportExport implements FromView
{
    use Exportable;
    protected $tableau;

    function __construct( $tableau) {
        $this->tableau = $tableau;
    }

    public function view(): View
    {
        return view('/rapport/visiteur', [
            'datas' => $this->tableau,
            'type' => 1
        ]);
    }
}
