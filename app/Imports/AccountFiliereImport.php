<?php

namespace App\Imports;

use App\Models\AccouteFiliereData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class AccountFiliereImport implements ToModel,WithHeadingRow
{
    
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        if ($row["Année de formation"] != 3) {
            return new AccouteFiliereData([
                //
                "filiere_code" => $row["Code Filière"],
                "year" => $row["Année de formation"],
                "group" => $row["Groupe"],
                "formateur"=>$row["Formateur Affecté Présentiel Actif"],
                "filiere_name"=>$row["filière"]
                
            ]);
        }
        return  null;
    }

    
}
