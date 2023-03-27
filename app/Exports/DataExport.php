<?php

namespace App\Exports;

use App\Models\Comments;
use App\Models\Donnee;
use App\Models\Element;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection,WithHeadings

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $allData = [];
        $allFiliere = Filiere::all();
        $allElement = Element::all();

        foreach ($allFiliere as $filiere) {
            # code...
            $code_filire = in_array($filiere->code_filiere, ["all", "all_a1", "all_a2"]) ? "toute" : $filiere->code_filiere;
            $filiere_full_name = in_array($filiere->name, ["all", "all_a1", "all_a2"]) ? "toute" : $filiere->name;
            $filiere_year = $filiere->annee == "12" ?"toute" : $filiere->annee;

            foreach ($allElement as $element) {
                # code...
                $element_name = $element->name;
                $element_aspeet = $element->aspeet()->first()->value;

                $Donne = Donnee::where([
                    ["filiere_id","=",$filiere->id],
                    ["element_id","=",$element->id],
                ])->first();

                $element_value = $Donne ? $Donne->value : 0;
                $element_comment = "";
                $Comment = Comments::where([
                    ["filiere_id","=",$filiere->id],
                    ["element_id","=",$element->id],
                ])->first();

                if($Comment){
                    foreach (json_decode($Comment->value) as $comments) {
                        # code...
                        if($comments->active){
                            $element_comment .=$comments->value.PHP_EOL;
                        }
                    }
                }

               
               $allData[] =  [$code_filire,$filiere_full_name,$filiere_year,$element_name,$element_aspeet,$element_value,$element_comment];
            }
        }


        return new Collection($allData);
        
    }

    public function headings(): array {
        return [
           "CODE Filiere","FILIERE NOM","ANNEE","ELÉMENTS DE TRAITEMENT","ASPEETS À TRAILER","LES DONNÉES","COMMENTAIRES"
        ];
      }
}
