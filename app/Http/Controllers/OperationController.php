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

    protected $code_filier;
    protected $annee;
    protected $count;
    protected $ConMoiFaiARRAY;
    protected $moiyen;
    protected $convenable;


    public function getNmbreTotalGroup($code_filier, $annee)
    {
        $NmbreTotalGroup = 0;
        //old code

        // if ($code_filier == 'all' and $annee == 12) {
        //     $NmbreTotalGroup = DataTable::distinct("groupe")->count();
        // } elseif (in_array($code_filier, ["all_a2", "all_a1"]) and $annee != 12) {
        //     $NmbreTotalGroup = DataTable::where("annee_formation", $annee)->distinct("groupe")->count();
        // } else {
        //     $NmbreTotalGroup = DataTable::where("code_filiere", $code_filier)->where("annee_formation", $annee)->distinct("groupe")->count();
        // }

        switch (true) {
            case $code_filier == "all":
                $NmbreTotalGroup = DataTable::distinct("groupe")->count();
                break;

            case in_array($code_filier, ["all_a2", "all_a1"]):
                $NmbreTotalGroup = DataTable::where("annee_formation", $annee)->distinct("groupe")->count();
                break;
            default:
                $NmbreTotalGroup = DataTable::where("code_filiere", $code_filier)->where("annee_formation", $annee)->distinct("groupe")->count();
                break;
        }

        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;
        $eleArray = [1, 39];
        foreach ($eleArray as $ele) {

            $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $ele)->first();

            if (isset($donne)) {
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

        $allGroupDistinct = null;
        $count = 0;
        // ---------
        $this->code_filier = $code_filier;
        $this->annee = $annee;
        $this->count = 0;

        //old code 
        // if ($code_filier == 'all' and $annee == 12) {
        //     $allGroupDistinct = DB::table("data_tables")->distinct("groupe")->get("groupe");
        // } elseif (in_array($code_filier, ["all_a2", "all_a1"])  and $annee != 12) {
        //     $allGroupDistinct = DB::table("data_tables")->where("annee_formation", $annee)->distinct("groupe")->get("groupe");
        // } else {
        //     $allGroupDistinct = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->distinct("groupe")->get("groupe");
        // }

        switch (true) {
            case $code_filier == "all":
                $allGroupDistinct = DB::table("data_tables")->distinct("groupe")->get("groupe");
                break;

            case in_array($code_filier, ["all_a2", "all_a1"]):
                $allGroupDistinct = DB::table("data_tables")->where("annee_formation", $annee)->distinct("groupe")->get("groupe");
                break;
            default:
                $allGroupDistinct = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->distinct("groupe")->get("groupe");
                break;
        }

        // --------------------------


        // foreach ($allGroupDistinct as $group) {
        //     if ($code_filier == 'all' and $annee == 12) {
        //         $numberModel = DB::table("data_tables")->where("groupe", $group->groupe)->count();
        //         $numberModelVlide = DB::table("data_tables")->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
        //     } elseif (in_array($code_filier, ["all_a2", "all_a1"])  and $annee != 12) {
        //         $numberModel = DB::table("data_tables")->where("annee_formation", $annee)->where("groupe", $group->groupe)->count();
        //         $numberModelVlide = DB::table("data_tables")->where("annee_formation", $annee)->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
        //     } else {
        //         $numberModel = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("groupe", $group->groupe)->count();
        //         $numberModelVlide = DB::table("data_tables")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
        //     }


        //     if ($numberModel == $numberModelVlide) {
        //         $count++;
        //     }
        // }

        array_map(function ($group) {
            $numberModel = 0;
            $numberModelVlide = 0;
            switch (true) {
                case $this->code_filier == "all":
                    $numberModel = DB::table("data_tables")->where("groupe", $group->groupe)->count();
                    $numberModelVlide = DB::table("data_tables")->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");
                    break;

                case in_array($this->code_filier, ["all_a2", "all_a1"]):
                    $numberModel = DB::table("data_tables")->where("annee_formation", $this->annee)->where("groupe", $group->groupe)->count();
                    $numberModelVlide = DB::table("data_tables")->where("annee_formation", $this->annee)->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");

                    break;
                default:
                    $numberModel = DB::table("data_tables")->where("code_filiere", $this->code_filier)->where("annee_formation", $this->annee)->where("groupe", $group->groupe)->count();
                    $numberModelVlide = DB::table("data_tables")->where("code_filiere", $this->code_filier)->where("annee_formation", $this->annee)->where("groupe", $group->groupe)->where("Taux_Realisation_P_syn", ">=", 95)->count("groupe");

                    break;
            }

            if ($numberModel === $numberModelVlide) {
                $this->count++;
            }
        }, $allGroupDistinct->toArray());


        // ------------------------------


        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;
        $id_element = 2;

        $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $id_element)->first();

        if (isset($donne)) {
            $donne->value = $this->count;
        } else {
            $donne = new Donnee();
            $donne->value = $this->count;
            $donne->filiere_id = $id_code_filier;
            $donne->element_id = $id_element;
        }

        $donne->save();
    }

    public function getNombreTotalGroupesTaux($code_filier, $annee, $convenable, $moiyen)
    {
        $allGroupWithTaux = null;
        //get total of groups that have taux convonabl and moiyen and faible and also achever
        $this->ConMoiFaiARRAY = ["convenable" => 0, "faible" => 0, "moiyen" => 0, "con&moi" => 0];
        $this->moiyen = $moiyen;
        $this->convenable = $convenable;
        $elements = [
            ["ele" => 40, "type" => "convenable"],
            ["ele" => 41, "type" => "moiyen"],
            ["ele" => 42, "type" => "faible"],
            ["ele" => 43, "type" => "con&moi"],

        ];
        // SELECT groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) from data_tables
        // WHERE annee_formation = 1 and code_filiere = "GC_GE_TS"
        // group by groupe

        switch (true) {
            case $code_filier == "all":
                $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->groupBy("groupe")->get();
                break;
            case in_array($code_filier, ["all_a2", "all_a1"]):
                $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->where("annee_formation", $annee)->groupBy("groupe")->get();
                break;
            default:
                $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->groupBy("groupe")->get();
                break;
        }

        // if ($code_filier == 'all' and $annee == 12) {
        //     $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->groupBy("groupe")->get();
        // } elseif (in_array($code_filier, ["all_a2", "all_a1"])  and $annee != 12) {
        //     $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->where("annee_formation", $annee)->groupBy("groupe")->get();
        // } else {
        //     $allGroupWithTaux = DB::table("data_tables")->selectRaw("groupe,CEIL((sum(mh_realisee_globale) /sum(MH_Affectee_Globale_P_SYN))*100) as taux")->where("code_filiere", $code_filier)->where("annee_formation", $annee)->groupBy("groupe")->get();
        // }

        // -----------------------------------------


        array_map(function ($key) {

            switch (true) {
                case $key->taux >=  $this->convenable:
                    # code...
                    $this->ConMoiFaiARRAY["convenable"]++;

                    break;
                case ($key->taux < $this->convenable && $key->taux >= $this->moiyen):
                    $this->ConMoiFaiARRAY["moiyen"]++;
                    break;
                default:
                    # code...
                    $this->ConMoiFaiARRAY["faible"]++;

                    break;
            }

            // if ($key->taux >= $convenable) {
            //     $ConMoiFaiARRAY["convenable"]++;
            // } elseif ($key->taux < $convenable && $key->taux >= $moiyen) {
            //     $ConMoiFaiARRAY["moiyen"]++;
            // } else {
            //     $ConMoiFaiARRAY["faible"]++;
            // }

        }, $allGroupWithTaux->toArray());



        $this->ConMoiFaiARRAY["con&moi"] = $this->ConMoiFaiARRAY["convenable"] + $this->ConMoiFaiARRAY["moiyen"];


        $id_code_filier = Filiere::all()->where("code_filiere", $code_filier)->where("annee", $annee)->first()->id;

        foreach ($elements as $key) {

            $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $key["ele"])->first();

            if (isset($donne)) {
                $donne->value = $this->ConMoiFaiARRAY[$key["type"]];
            } else {
                $donne = new Donnee();
                $donne->value = $this->ConMoiFaiARRAY[$key["type"]];
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

        switch (true) {
            case $code_filier == "all":
                $CountModule = DataTable::all()->count("module");

                break;

            case in_array($code_filier, ["all_a2", "all_a1"]):
                $CountModule = DataTable::all()->where("annee_formation", $annee)->count("module");

                break;
            default:
                $CountModule = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->count("module");

                break;
        }

        // if ($code_filier == 'all' and $annee == 12) {
        //     $CountModule = DataTable::all()->count("module");
        // } elseif (in_array($code_filier, ["all_a2", "all_a1"])  and $annee != 12) {
        //     $CountModule = DataTable::all()->where("annee_formation", $annee)->count("module");
        // } else {
        //     $CountModule = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->count("module");
        // }
        //---------------------------------------------------

        $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $eleid)->first();

        if (isset($donne)) {
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

        switch (true) {
            case $code_filier == "all":
                $CountModuleAchever = DataTable::all()->where("Taux_Realisation_P_syn", ">=", 95)->count("module");

                break;

            case in_array($code_filier, ["all_a2", "all_a1"]):
                $CountModuleAchever = DataTable::all()->where("annee_formation", $annee)->where("Taux_Realisation_P_syn", ">=", 95)->count("module");

                break;
            default:
                $CountModuleAchever = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Taux_Realisation_P_syn", ">=", 95)->count("module");

                break;
        }

        // if ($code_filier == 'all' and $annee == 12) {
        //     $CountModuleAchever = DataTable::all()->where("Taux_Realisation_P_syn", ">=", 95)->count("module");
        // } elseif (in_array($code_filier, ["all_a2", "all_a1"])  and $annee != 12) {
        //     $CountModuleAchever = DataTable::all()->where("annee_formation", $annee)->where("Taux_Realisation_P_syn", ">=", 95)->count("module");
        // } else {
        //     $CountModuleAchever = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Taux_Realisation_P_syn", ">=", 95)->count("module");
        // }

        // /-------------------------------------------------------------------
        $donne = Donnee::all()->where("filiere_id", $id_code_filier)->where("element_id", $eleid)->first();

        if (isset($donne)) {
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
        $CountEFMLocalesPrevues = 0;
        $CountEFMRegionalPrevues = 0;
        $CountEFMLocalesréalisées = 0;
        $CountEFMRegionalréalisées = 0;
        
        switch (true) {
            case $code_filier == "all":
                $CountEFMLocalesPrevues = DataTable::all()->where("Regional", "N")->where("Seance_EFM", "Non")->count();
                $CountEFMRegionalPrevues = DataTable::all()->where("Regional", "O")->where("Seance_EFM", "Non")->count();
                $CountEFMLocalesréalisées = DataTable::all()->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
                $CountEFMRegionalréalisées = DataTable::all()->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
                break;

            case in_array($code_filier, ["all_a2", "all_a1"]):
                $CountEFMLocalesPrevues = DataTable::all()->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Non")->count();
                $CountEFMRegionalPrevues = DataTable::all()->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Non")->count();
                $CountEFMLocalesréalisées = DataTable::all()->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
                $CountEFMRegionalréalisées = DataTable::all()->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
                break;
            default:
                $CountEFMLocalesPrevues = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Non")->count();
                $CountEFMRegionalPrevues = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Non")->count();
                $CountEFMLocalesréalisées = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
                $CountEFMRegionalréalisées = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
                break;
        }

        // if ($code_filier == 'all' and $annee == 12) {
        //     $CountEFMLocalesPrevues = DataTable::all()->where("Regional", "N")->where("Seance_EFM", "Non")->count();
        //     $CountEFMRegionalPrevues = DataTable::all()->where("Regional", "O")->where("Seance_EFM", "Non")->count();
        //     $CountEFMLocalesréalisées = DataTable::all()->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
        //     $CountEFMRegionalréalisées = DataTable::all()->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
        // } elseif (in_array($code_filier, ["all_a2", "all_a1"])  and $annee != 12) {
        //     $CountEFMLocalesPrevues = DataTable::all()->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Non")->count();
        //     $CountEFMRegionalPrevues = DataTable::all()->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Non")->count();
        //     $CountEFMLocalesréalisées = DataTable::all()->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
        //     $CountEFMRegionalréalisées = DataTable::all()->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
        // } else {
        //     $CountEFMLocalesPrevues = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Non")->count();
        //     $CountEFMRegionalPrevues = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Non")->count();
        //     $CountEFMLocalesréalisées = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "N")->where("Seance_EFM", "Oui")->count();
        //     $CountEFMRegionalréalisées = DataTable::all()->where("code_filiere", $code_filier)->where("annee_formation", $annee)->where("Regional", "O")->where("Seance_EFM", "Oui")->count();
        // }

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

    public function setDefaultValuesForOtherElements($code_filier, $annee)
    {
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


    public function setDefaultCommentForOtherElements($code_filier, $annee)
    {
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
