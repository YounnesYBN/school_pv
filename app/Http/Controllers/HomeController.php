<?php

namespace App\Http\Controllers;

use App\Models\Donnee;
use App\Models\Element;
use App\Models\Filiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function GetDataAndDisplayIt(Request $request)
    {

        $shoudCommentDisplay = false;
        // get all aspeet for the user depinding on his email and passwrod and we also get for each aspeets all it's elements 
        $check = User::all()->where('email', session("email"))->first();

        $Allaspeet = $check->type()->first()->aspeet()->get();
        // return dd($Allaspeet); 

        $aspeet_element_Array = array();
        foreach ($Allaspeet as $aspeet) {

            $aspeet_element_Array[] = [

                "aspeet" => $aspeet,
                "elements" => $aspeet->element()->get()

            ];
        }

        //here finding filier when he selected the year and filier or not 
        if ($selectedYear = $request->selectYear) {
            $selectedFilier = $request->filierSelect;

            session(["selected_filier" => $selectedFilier, "selected_year" => $selectedYear]);
            $filier = Filiere::all()->where("annee", $selectedYear)->where("code_filiere", $selectedFilier)->first();
            $shoudCommentDisplay = ($selectedFilier != "all" && $selectedFilier != "all_a1" && $selectedFilier != "all_a2") ? true : false;
        } else {
            if ($sessionYear = session("selected_year")) {
                $sessionFilier = session("selected_filier");
                $filier = Filiere::all()->where("annee", $sessionYear)->where("code_filiere", $sessionFilier)->first();
                $shoudCommentDisplay = ($sessionFilier != "all" && $sessionFilier != "all_a1" && $sessionFilier != "all_a2") ? true : false;
            } else {
                session(["selected_filier" => "all", "selected_year" => "12"]);

                $filier = Filiere::all()->where("annee", "12")->where("code_filiere", "all")->first();
                $shoudCommentDisplay = false;
            }
        }


        $donnes = Donnee::all()->where("filiere_id", $filier->id);
        $comments = $filier->comment()->get();

        //here we give for each element its donne and comment


        foreach ($aspeet_element_Array as $aspeet_element) {
            //aspeet and elements
            foreach ($aspeet_element["elements"] as $element) {
                //all elements 

                foreach ($donnes as $donne) {
                    # all donnes

                    if ($donne->element_id == $element->id) {



                        $element->donne = $donne;
                    }
                }

                foreach ($comments as $comment) {
                    # all comment

                    if ($comment->element_id == $element->id) {
                        $element->comment = $comment;
                    }
                }
            }
        }


        

        
        return view("home", [
            "data" => $aspeet_element_Array,
            "comment_display" => $shoudCommentDisplay,
        ]);
    }

    public function SaveDonneChanges(Request $request)
    {

        $year_selected = session("selected_year");
        $filier_selected = session("selected_filier");

        $filierOBJ = Filiere::where([
            ["code_filiere", "=", $filier_selected],
            ["annee", "=", $year_selected]
        ])->first();

        $avoided_elements = Element::where([
            ["type_comment", "=", "select"]
        ])->orWhereIn("id", [
            1, 2, 14, 15, 16, 17, 18, 19, 39, 40, 41, 42, 43
        ])->get();

        $Non_avoided_elements = array();
        foreach ($request->input() as $key => $value) {
            $found = false;

            foreach ($avoided_elements as $element) {
                if ($element->id == $key) {
                    $found = true;
                }
            }

            if (!$found && $key != "_token") {
                $Non_avoided_elements[] = ["id" => $key, "value" => $value];
            }
        }




        foreach ($Non_avoided_elements as $values) {

            $elementOBJ = Element::where("id", $values["id"])->first();

            $donne = Donnee::where([
                ["filiere_id", "=", $filierOBJ->id],
                ["element_id", "=", $elementOBJ->id],
            ])->first();

            if ($donne) {
                $donne->value = $values["value"] ? $values["value"] : 0;
            } else {
                $donne = new Donnee();
                $donne->filiere_id = $filierOBJ->id;
                $donne->element_id = $elementOBJ->id;
                $donne->value = $values["value"] ? $values["value"] : 0;
            }
            $donne->save();
        }











        foreach ($Non_avoided_elements as $values2) {
            # code...
            $years  = ["all_a1" => 0, "all_a2" => 0, "all" => 0];

            $years["all_a1"] =  DB::table("donnees")
                ->selectRaw("sum(value) as total")
                ->join('elements', 'elements.id', '=', 'donnees.element_id')
                ->join('filieres', 'filieres.id', '=', 'donnees.filiere_id')
                ->where([
                    ["elements.id", "=", $values2["id"]],
                    ["filieres.annee", "=", 1],
                    ["filieres.code_filiere", "!=", "all_a1"],
                ])->first()->total;

            $years["all_a2"] = DB::table("donnees")
                ->selectRaw("sum(value) as total")
                ->join('elements', 'elements.id', '=', 'donnees.element_id')
                ->join('filieres', 'filieres.id', '=', 'donnees.filiere_id')
                ->where([
                    ["elements.id", "=", $values2["id"]],
                    ["filieres.annee", "=", 2],
                    ["filieres.code_filiere", "!=", "all_a2"],
                ])->first()->total;

            // $years["all"] = $years["all_a2"] + $years["all_a1"];
            $sum_of_all = array_sum(array_intersect_key($years, array_flip(['all_a1', 'all_a2'])));
            $years['all'] = $sum_of_all;

            $filiere_allYears_array = Filiere::whereIn("code_filiere", ["all_a1", "all_a2", "all"])->get();

            foreach ($filiere_allYears_array as $year) {
                # code...

                $donne = Donnee::where([
                    ["element_id", "=", $values2["id"]],
                    ["filiere_id", "=", $year->id]
                ])->first();
                if ($donne) {
                    $donne->value = $years[$year->code_filiere];
                } else {
                    $donne = new Donnee();
                    $donne->element_id = $values2["id"];
                    $donne->filiere_id = $year->id;
                    $donne->value = $years[$year->code_filiere];
                }
                $donne->save();
            }
        }

        return back();
    }
}
