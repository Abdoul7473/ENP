<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class DepositsExport implements FromView
{
    use Exportable;

    protected $deposits;
    protected $total;
    protected $filters;

    public function __construct($deposits, $total, $filters = [])
    {
        $this->deposits = $deposits;
        $this->total = $total;
        $this->filters = $filters;
    }

    public function view(): View
    {
        return view('rapport/deposits', [
            'deposits' => $this->deposits,
            'total' => $this->total,
            'filters' => $this->filters,
        ]);
    }
}
