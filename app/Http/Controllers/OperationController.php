<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\DataTable;
use App\Models\Donnee;
use App\Models\Element;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class OperationController extends Controller
{
    //


    public function getNmbreTotalGroup($code_filier, $annee)
    {
        if ($code_filier == 'all' and $annee == 12) {
            $NmbreTotalGroup = DataTable::distinct("groupe")->count();
        } elseif (in_array($code_filier,["all_a2","all_a1"]) and $annee != 12) {
            $NmbreTotalGroup = DataTable::where("annee_formation", $annee)->distinct("groupe")->count();
        } else {
            $NmbreTotalGroup = DataTable::where("code_filiere", $code_filier)->where("annee_formation", $annee)->distinct("groupe")->count();
        }


        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;
        $eleArray = [1, 39];
        foreach ($eleArray as $ele) {

            $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $ele)->first();

            if ($donne) {
                $donne->value = $NmbreTotalGroup;
            } else {
                $donne = new Donnee();
                $donne->value = $NmbreTotalGroup;
                $donne->filiere_id = $id_code_filier;
                $donne->element_id = $ele;
            }

            $donne->save();
        }
    }


    public function getNombreTotalGroupesValides($code_filier, $annee)
    {

        $count = 0;
        if ($code_filier == 'all' and $annee == 12) {
            $allGroupDistinct = DB::table("data_tables")->distinct("groupe")->get("groupe");
        } elseif (in_array($code_filier,["all_a2","all_a1"])  and $annee != 12) {
            $allGroupDistinct = DB::table("data_tables")->where("annee_formation", $annee)->distinct("groupe")->get("groupe");
        } else {
            $allGroupDistinct = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->distinct("groupe")->get("groupe");
        }
        foreach ($allGroupDistinct as $group) {
            if ($code_filier == 'all' and $annee == 12) {
                $numberModel = DB::table("data_tables")->where("groupe", $group->groupe)->count();
                $numberModelVlide = DB::table("data_tables")->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
            } elseif (in_array($code_filier,["all_a2","all_a1"])  and $annee != 12) {
                $numberModel = DB::table("data_tables")->where("annee_formation", $annee)->where("groupe", $group->groupe)->count();
                $numberModelVlide = DB::table("data_tables")->where("annee_formation", $annee)->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
            } else {
                $numberModel = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("groupe", $group->groupe)->count();
                $numberModelVlide = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
            }
            if ($numberModel == $numberModelVlide) {
                $count++;
            }
        }

        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;
        $id_element = 2;

        $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $id_element)->first();

        if ($donne) {
            $donne->value = $count;
        } else {
            $donne = new Donnee();
            $donne->value = $count;
            $donne->filiere_id = $id_code_filier;
            $donne->element_id = $id_element;
        }

        $donne->save();
    }

    public function getNombreTotalGroupesTaux($code_filier, $annee, $convenable, $moiyen)
    {
        //get total of groups that have taux convonabl and moiyen and faible and also achever
        $ConMoiFaiARRAY = ["convenable" => 0, "faible" => 0, "moiyen" => 0, "con&moi" => 0];
        $elements = [
            ["ele" => 40, "type" => "convenable"],
            ["ele" => 41, "type" => "moiyen"],
            ["ele" => 42, "type" => "faible"],
            ["ele" => 43, "type" => "con&moi"],

        ];
        // SELECT groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) from data_tables
        // WHERE annee_formation = 1 and code_filiere = "GC_GE_TS"
        // group by groupe


        if ($code_filier == 'all' and $annee == 12) {
            $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->groupBy("groupe")->get();
        } elseif (in_array($code_filier,["all_a2","all_a1"])  and $annee != 12) {
            $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->where("annee_formation", $annee)->groupBy("groupe")->get();
        } else {
            $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->groupBy("groupe")->get();
        }

        foreach ($allGroupWithTaux as $key) {
            if ($key->taux >= $convenable) {
                $ConMoiFaiARRAY["convenable"]++;
            } elseif ($key->taux < $convenable && $key->taux >= $moiyen) {
                $ConMoiFaiARRAY["moiyen"]++;
            } else {
                $ConMoiFaiARRAY["faible"]++;
            }
        }
        $ConMoiFaiARRAY["con&moi"] = $ConMoiFaiARRAY["convenable"] + $ConMoiFaiARRAY["moiyen"];


        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;
        foreach ($elements as $key) {

            $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $key["ele"])->first();

            if ($donne) {
                $donne->value = $ConMoiFaiARRAY[$key["type"]];
            } else {
                $donne = new Donnee();
                $donne->value = $ConMoiFaiARRAY[$key["type"]];
                $donne->filiere_id = $id_code_filier;
                $donne->element_id = $key["ele"];
            }

            $donne->save();
        }
    }


    public function getTotalModule($code_filier, $annee)
    {

        $eleid = 14;
        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;

        if ($code_filier == 'all' and $annee == 12) {
            $CountModule = DataTable::all()->count("module");
        } elseif (in_array($code_filier,["all_a2","all_a1"])  and $annee != 12) {
            $CountModule = DataTable::all()->where("annee_formation", $annee)->count("module");
        } else {
            $CountModule = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->count("module");
        }

        $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $eleid)->first();

        if ($donne) {
            $donne->value = $CountModule;
        } else {
            $donne = new Donnee();
            $donne->value = $CountModule;
            $donne->filiere_id = $id_code_filier;
            $donne->element_id = $eleid;
        }

        $donne->save();
    }


    public function getTotalModuleAchever($code_filier, $annee)
    {
        $eleid = 15;
        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;

        if ($code_filier == 'all' and $annee == 12) {
            $CountModuleAchever = DataTable::all()->where("Taux_Realisation_P_syn", ">=", 95)->count("module");
        } elseif (in_array($code_filier,["all_a2","all_a1"])  and $annee != 12) {
            $CountModuleAchever = DataTable::all()->where("annee_formation", $annee)->where("Taux_Realisation_P_syn", ">=", 95)->count("module");
        } else {
            $CountModuleAchever = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Taux_Realisation_P_syn", ">=", 95)->count("module");
        }

        $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $eleid)->first();

        if ($donne) {
            $donne->value = $CountModuleAchever;
        } else {
            $donne = new Donnee();
            $donne->value = $CountModuleAchever;
            $donne->filiere_id = $id_code_filier;
            $donne->element_id = $eleid;
        }

        $donne->save();
    }

    public function getTotalEFM_local_regional($code_filier, $annee)
    {

        //get total of EFM local and regional in both prevues and realisees
        $EFMArray = [
            ["locales prévues" => 0],
            ["régionales prévues" => 0],
            ["locales réalisées" => 0],
            ["régionales réalisées" => 0],
        ];

        $idElements = [
            ["id" => 16, "type" => "locales prévues"],
            ["id" => 17, "type" => "régionales prévues"],
            ["id" => 18, "type" => "locales réalisées"],
            ["id" => 19, "type" => "régionales réalisées"]
        ];
        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;


        if ($code_filier == 'all' and $annee == 12) {
            $CountEFMLocalesPrevues = DataTable::all()->where("Regional", "N")->where("Seance_EFM", "Non")->count();
            $CountEFMRegionalPrevues = DataTable::all()->where("Regional", "O")->where("Seance_EFM", "Non")->count();
            $CountEFMLocalesréalisées = DataTable::all()->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
            $CountEFMRegionalréalisées = DataTable::all()->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
        } elseif (in_array($code_filier,["all_a2","all_a1"])  and $annee != 12) {
            $CountEFMLocalesPrevues = DataTable::all()->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Non")->count();
            $CountEFMRegionalPrevues = DataTable::all()->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Non")->count();
            $CountEFMLocalesréalisées = DataTable::all()->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
            $CountEFMRegionalréalisées = DataTable::all()->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
        } else {
            $CountEFMLocalesPrevues = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Non")->count();
            $CountEFMRegionalPrevues = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Non")->count();
            $CountEFMLocalesréalisées = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
            $CountEFMRegionalréalisées = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
        }

        $EFMArray["locales prévues"] = $CountEFMLocalesPrevues;
        $EFMArray["régionales prévues"] = $CountEFMRegionalPrevues;
        $EFMArray["locales réalisées"] = $CountEFMLocalesréalisées;
        $EFMArray["régionales réalisées"] = $CountEFMRegionalréalisées;


        foreach ($idElements as $key) {

            $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $key["id"])->first();

            if ($donne) {
                $donne->value = $EFMArray[$key["type"]];
            } else {
                $donne = new Donnee();
                $donne->value = $EFMArray[$key["type"]];
                $donne->filiere_id = $id_code_filier;
                $donne->element_id = $key["id"];
            }

            $donne->save();
        }


    }

    public function setDefaultValuesForOtherElements($code_filier, $annee){
        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;

        $Non_avoided_elements = Element::where([
            ["type_comment", "!=", "select"]
        ])->WhereNotIn("id", [
            1, 2, 14, 15, 16, 17, 18, 19, 39, 40, 41, 42, 43
        ])->get();

        foreach ($Non_avoided_elements as $element) {
            $donne = Donnee::where([
                ["filiere_id", "=", $id_code_filier],
                ["element_id", "=", $element->id],
            ])->first();
            
            if ($donne) {
                $donne->value = 0;
            } else {
                $donne = new Donnee();
                $donne->filiere_id = $id_code_filier;
                $donne->element_id = $element->id;
                $donne->value = 0;
            }

            $donne->save();
        }

    }


    public function setDefaultCommentForOtherElements($code_filier, $annee){
        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;

        $elements = Element::all();

        foreach ($elements as $element) {
            $comment = Comments::where([
                ["filiere_id", "=", $id_code_filier],
                ["element_id", "=", $element->id],
            ])->first();
            
            if (!isset($comment)) {
                $comment = new Comments();
                $comment->filiere_id = $id_code_filier;
                $comment->element_id = $element->id;
                $comment->value = json_encode([]);
                $comment->save();
            }
        }

    }
    

}


