<?php

namespace App\Imports;

use App\Models\Eleve;
use App\Models\Annee;
use App\Models\Compagnie;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ElevesImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $tableau;
    function __construct($tableau) {
        $this->tableau = $tableau;
    }
   
    public function model(array $row)
    {
        // dd($this->tableau);
        $annee = Annee::where('statut',1)->first();
        $eleve =  Eleve::create([
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'date_naiss' => $row['date_naiss'],
            'sexe' => $row['sexe'],
            'tel' => $row['tel'],
            'lieu_naiss' => $row['lieu_naiss'],
            'groupe_sanguin' => $row['groupe_sanguin'],
            'compagnie_id' =>  $this->tableau->compagnie_id
        ]);
        
        $compagnie = Compagnie::where('id',$this->tableau->compagnie_id)->get()[0];
        if (strlen($eleve->id)== 1) {
            $num = '000' . $eleve->id;
        }elseif(strlen($eleve->id)== 2){
            $num = '00' . $eleve->id;
        }elseif(strlen($eleve->id)==3){
            $num = '0'.$eleve->id;
        }else{
            $num = $eleve->id;
        }
        $matricule = $num . $compagnie->sigle . '-' .$annee->code.'DENP';
        $eleve->matricule = $matricule;
        $eleve->ordre = $num;
        $eleve->update();
    }
    public function rules(): array
    {
        return [
            
        ];
    }
}
