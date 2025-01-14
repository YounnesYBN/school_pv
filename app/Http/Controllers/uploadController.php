<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\dataImport;
use App\Models\DataTable;
use App\Models\Filiere;

class uploadController extends Controller
{
    //
    public $moiyen ;
    public $convonable ;
    
    public function Onupload(Request $request): string
    {
        set_time_limit(300);

        $input = [
            "file_import" => $request->file_import,
            "convenable" => $request->convenable,
            "moiyen" => $request->moiyen,
        ];
        
        Validator::validate(
            $input,
            [
                "file_import" => ["required"],
                "moiyen" => ["required",],
                "convenable" => ["required"],
            ],
            [

                "moiyen" => [
                    "required" => "moyenne est requis"
                    
                ],
                "convenable" => [
                    "required" => "convenable est requis"
                ],
                "file_import" => [
                    "required" => "assurez-vous d'importer le fichier",
                    "mimes" => "le fichier doit être de type:xlsx,xls"
                ]

            ]
        );

        if ($request->convenable < $request->moiyen) {
            return back()->with("error", "convenable devrait être plus grand que moyenne");
        }
        if(Filiere::all()->count() == 0){
            return back()->with("error", "créer d'abord des filieres");
        }

        if (DataTable::all()->first()) {
            
            DataTable::truncate();
        }

        try {
            //code...
            Excel::import(new dataImport, $request->file("file_import")->store("temp"));
        } catch (\Throwable $th) {
            return back()->with("error", "la forme du fichier n'est pas correcte,le fichier doit contenir ces colonnes (
                Code Filière,
                Année de formation,
                Module,
                Taux Réalisation (P & SYN ),
                MH Réalisée Globale,
                Groupe,
                Régional,
                Séance EFM,
                filière,
                MH Affectée Globale (P & SYN)
            )");
        }

        try {
            //code...
            $allFilier = Filiere::all()->toArray();
            $this->moiyen =  $request->moiyen;
            $this->convonable =  $request->convenable;
            array_map(function($filier){
                $operationOBJ = new OperationController();
                
                $operationOBJ->setDefaultValuesForOtherElements($filier["code_filiere"], $filier["annee"]);
                $operationOBJ->setDefaultCommentForOtherElements($filier["code_filiere"], $filier["annee"]);
                $operationOBJ->getNmbreTotalGroup($filier["code_filiere"], $filier["annee"]);
                $operationOBJ->getNombreTotalGroupesValides($filier["code_filiere"], $filier["annee"]);
                $operationOBJ->getNombreTotalGroupesTaux($filier["code_filiere"], $filier["annee"], $this->convonable, $this->moiyen);
                $operationOBJ->getTotalModule($filier["code_filiere"], $filier["annee"]);
                $operationOBJ->getTotalModuleAchever($filier["code_filiere"], $filier["annee"]);
                $operationOBJ->getTotalEFM_local_regional($filier["code_filiere"], $filier["annee"]);
            },$allFilier);
            
            return redirect("/");
            
        } catch (\Throwable $th) {
            //throw $th;

            return back()->with("error", "quelque chose s'est mal passé");
        }
    }
}
