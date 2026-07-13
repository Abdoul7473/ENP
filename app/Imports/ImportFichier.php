<?php

namespace App\Imports;

use App\Models\Aeroport;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportFichier implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Aeroport([
            'nom'=>$row['nom'],
            'code'=>$row['code'],
            'pays'=>$row['pays'],
        ]);
    }
}
