<?php

namespace App\Http\Controllers;

use App\Models\Donnee;
use App\Models\Filiere;
use App\Models\FormateurDonneeComment;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FormateurHomeController extends Controller
{
    //

    public function GetDataAndDisplayIt(Request $request)
    {
        $shoudCommentDisplay = false;
        $filiereDistinct = [];
        $aspeet_element_Array = [];
        $shouldTableDisplay = false;

        $user = User::all()->where('email', session("email"))->first();
        if (!$user) {
            return redirect("/login");
        }

        // ---------------get filiere distict-------------------------------
        $groups = $user->group()->get();

        foreach ($groups as  $group) {
            $newFiliere = $group->filiere()->first();
            if (!in_array($newFiliere->code_filiere, $filiereDistinct)) {
                $filiereDistinct[] = $newFiliere->code_filiere;
            }
        }
        // ---------------------------------------------
        //----------------------get aspeet and elements ------------------------
        $Allaspeet = $user->type()->first()->aspeet()->get();
        foreach ($Allaspeet as $aspeet) {

            $aspeet_element_Array[] = [

                "aspeet" => $aspeet,
                "elements" => $aspeet->element()->get()

            ];
        }
        //---------------------------------------------

        //-----------------------finding selected filiere
        if ($selectedFiliere = $request->selectFiliere) {
            if ($selectedFiliere == "default") {
                session()->forget(["selectedFiliere","selectedYear","selectedFiliereId","selectedGroup","selectedGroupName"]);  
                $shouldTableDisplay = false;
            } else {

                $shouldTableDisplay = true;
                $filiereAndYear = json_decode($request->selectFiliere);
                $filiereOBJ = Filiere::where("code_filiere", $filiereAndYear->filiere)->where("annee", $filiereAndYear->year)->first();
                session(["selectedFiliere" => $filiereOBJ->code_filiere, "selectedYear" => $filiereOBJ->annee,"selectedFiliereId"=>$filiereOBJ->id]);

                $shoudCommentDisplay = true;
                $selectedGroup = $request->selectGroup;
                $groupOBJ = Group::where("id", $selectedGroup)->first();
                session(["selectedGroup"=>$groupOBJ->id,"selectedGroupName"=>$groupOBJ->name]);
            }
        } else {
            if (session("selectedFiliere")) {
                $shouldTableDisplay = true;
                $filiereOBJ = Filiere::where("code_filiere", session("selectedFiliere"))->where("annee", session("selectedYear"))->first();
                $groupOBJ = Group::where("id", session("selectedGroup"))->first();
            } else {
                $shouldTableDisplay = false;
            }
        }
        //--------------------------------------------------
        if ($shouldTableDisplay) {
            $donnes = Donnee::all()->where("filiere_id", $filiereOBJ->id);
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

                    $element->comment = FormateurDonneeComment::where([
                        ["element_id","=",$element->id],
                        ["filiere_id","=",$filiereOBJ->id],
                        ["group_id","=",$groupOBJ->id],
                        ["user_id","=",$user->id],
                    ])->first();

                    // foreach ($comments as $comment) {
                    //     # all comment

                    //     if ($comment->element_id == $element->id) {
                    //         $element->comment = $comment;
                    //     }
                    // }
                }
            }
        }
        return view("pages.formateurHome", [
            "filiers" => Filiere::whereIn("code_filiere", $filiereDistinct)->get(),
            "data" => $aspeet_element_Array,
            "shouldTbaleDisplay" => $shouldTableDisplay,
            "selectedFiliere" =>isset($filiereOBJ)?$filiereOBJ:null,
            "selectedGroup"=>isset($groupOBJ)?$groupOBJ:null,
        ]);
    }
}
