<?php

namespace App\Exports;

use App\Models\Order;

use Generator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class AutorisationExport extends StringValueBinder implements FromView, ShouldAutoSize, WithCustomValueBinder
{
    /**
    * @return \Illuminate\Support\Collection
    */

        use Exportable;
        protected $data;
         public function __construct( array $data)
        {
            $this->data=$data;
        }
        public function  view(): View
        {

            return view('rapportComptableExcel', $this->data);
        }

        public function bindValue(Cell $cell, $value)
        {
            if (is_string($value)) {
                $cell->setValueExplicit($value, DataType::TYPE_STRING);
                return true;
            }

            return parent::bindValue($cell, $value);
        }
    // protected $data_payes,$total_payes,$data_impayes,$total_impayes;


    // public function __construct( Collection $data_payes,$total_payes,$data_impayes,$total_impayes)
    // {
    //     $this->data_payes = $data_payes;
    //     $this->total_payes = $total_payes;
    //     $this->data_impayes = $data_impayes;
    //     $this->total_impayes = $total_impayes;
    //     // dd( $this->data_payes,$this->total_payes);
    // }

    // use Exportable;

    // public function generator(): Generator
    // {
    //     if($this->total_payes!=0){
    //         yield ['LES ETATS DES FACTURES POUR LES AUTORISATIONS PAYEES'];
    //         yield ['','','',''];
    //         yield ['Postulant','Telephone','Motif Vol','Montant'];
    //         foreach ($this->data_payes as $key => $value) {
    //             $tel = '';
    //             foreach ($value->postulant->tel as $key => $telValue) {
    //                 $tel .= $telValue . "\n"; // Ajoute une nouvelle ligne
    //             }
    //             yield [$value->postulant->nom_raison_sociale,$tel,$value->demande->type_demande->libelle, $value->prix_total];
    //         }
    //         yield ['','','Total',$this->total_payes];
    //         for ($i=0; $i < 4 ; $i++) {
    //             # code...
    //             yield ['','','',''];
    //         }
    //     }


    //     if($this->total_impayes!=0){
    //         yield ['LES ETATS DES FACTURES POUR LES AUTORISATIONS IMPAYEES'];
    //         yield ['','','',''];
    //         yield ['Postulant','Telephone','Motif Vol','Montant'];
    //         foreach ($this->data_impayes as $key => $value) {
    //             $tel = '';
    //             foreach ($value->postulant->tel as $key => $telValue) {
    //                 $tel .= $telValue . "\n"; // Ajoute une nouvelle ligne
    //             }
    //             yield [$value->postulant->nom_raison_sociale,$tel,$value->demande->type_demande->libelle, $value->prix_total];
    //         }
    //         yield ['','','Total', $this->total_impayes];

    //     }
    // }

}
