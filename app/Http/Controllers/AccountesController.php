<?php

namespace App\Http\Controllers;

use App\Imports\AccountFiliereImport;
use App\Models\AccouteFiliereData;
use App\Models\Filiere;
use App\Models\Group;
use App\Models\Type;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class AccountesController extends Controller
{
    //

    public function AccounteIndex(Request $request)
    {

        $formateur_type = Type::where("type_name", "formateur")->first();
        $allFormateurCount = User::where("type_id", $formateur_type->id)->count();
        $data = ["count" => $allFormateurCount];

        if ($request->search && strlen($request->search) > 0) {
            $allFormateur = DB::table("users")->select(["id", "email", "active", "type_id"])
                ->whereRaw("email like '%{$request->search}%'")
                ->where("type_id", $formateur_type->id)
                ->get();
            $data["data"] = $allFormateur;
            $data["search"] = $request->search;
        } else {
            $allFormateur = User::where("type_id", $formateur_type->id)->get();
            $data["data"] = $allFormateur;
        }


        return view("pages.Accounts&filieres", $data);
    }

    public function deleteFormateur($id)
    {
        $user = User::find($id);
        $type = $user->type()->first()->type_name;
        if ($type == "formateur") {
            User::where("id", $id)->delete();
        }

        return back();
    }
    public function DisActiveFormateur($id)
    {
        $user = User::find($id);
        $type = $user->type()->first()->type_name;
        if ($type == "formateur") {
            $user->active = false;
            $user->save();
        }

        return back();
    }
    public function ActiveFormateur($id)
    {
        $user = User::find($id);
        $type = $user->type()->first()->type_name;
        if ($type == "formateur") {
            $user->active = true;
            $user->save();
        }

        return back();
    }
    public function OnUpload(Request $request)
    {
        // return dd($request->file());
        $request->validate(

            [
                "uploadFile" => ["required", "mimes:xlsx,xls"],
            ],
            [
                "uploadFile.required" => "assurez-vous d'importer le fichier",
                "uploadFile.mimes" => "le fichier doit être de type:xlsx,xls"
            ]
        );

        if (AccouteFiliereData::all()->first()) {

            AccouteFiliereData::truncate();
        }

        try {
            //code...
            Excel::import(new AccountFiliereImport, $request->file("uploadFile")->store("temp"));
        } catch (\Throwable $th) {
            return back()->with("error", "la forme du fichier n'est pas correcte,le fichier doit contenir ces colonnes (
                'Code Filière',
                'Année de formation',
                'Groupe',
                'Formateur Affecté Présentiel Actif',
                'filière',
                
            )");
        }

        try {
            //this code when its runs it inserts filiere and groups and link between them
            DB::beginTransaction();

            DB::table('data_tables')->delete();
            DB::table("filieres")->delete();

            //get filiere distict
            $allFiliere = DB::table("accoute_filiere_data")->select(DB::raw("DISTINCT(filiere_code),year,filiere_name"))->get()->toArray();

            //get for each filiere its distinct groups and link them to each other 
            array_map(function ($filiere) {

                $filiereOBJ  = Filiere::where("code_filiere", $filiere->filiere_code)->first();
                if (!$filiereOBJ) {

                    $filiereOBJ = new Filiere([
                        "code_filiere" => $filiere->filiere_code,
                        "annee" => $filiere->year,
                        "name" => $filiere->filiere_name
                    ]);
                    $filiereOBJ->save();
                }

                $allGroupFiliere = DB::table("accoute_filiere_data")->select(DB::raw("DISTINCT(filiere_code),`group`"))->where([
                    ["filiere_code", "=", $filiere->filiere_code],
                    ["year", "=", $filiere->year]
                ])->get()->toArray();
                $allGroupFiliereOBJ = array_map(function ($group) {
                    $groupOBJ = new Group();
                    $groupOBJ->name = $group->group;
                    return $groupOBJ;
                }, $allGroupFiliere);

                $filiereOBJ->group()->saveMany($allGroupFiliereOBJ);
            }, $allFiliere);

            //add remening filier  
            array_map(function ($otherFili) {
                Filiere::create([
                    "name" => $otherFili["name"],
                    "code_filiere" => $otherFili["code_filiere"],
                    "annee" => $otherFili["annee"],
                ]);
            }, [
                ["name" => "all", "code_filiere" => "all", "annee" => "12"],
                ["name" => "all_a1", "code_filiere" => "all_a1", "annee" => "1"],
                ["name" => "all_a2", "code_filiere" => "all_a2", "annee" => "2"]
            ]);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return back()->with("error", "quelque chose s'est mal passé");
        }

        try {
            //when this code  runs it create users of type formateur and give foreach user his groups 
            DB::beginTransaction();
            User::where("type_id", Type::where("type_name", "formateur")->first()->id)->delete();
            $AllGroups = Group::get()->toArray();
            array_map(function ($group) {
                $group = Group::find($group["id"]);
                $allFormateur = DB::table("accoute_filiere_data")->select(DB::raw("distinct(`group`),`formateur`"))->where("group", $group->name)->get()->toArray();

                array_map(function ($formateur) {
                    if (strlen($formateur->formateur) > 0) {
                        $groupOBJ = Group::where("name", $formateur->group)->first();
                        $formateurType = Type::where("type_name", "formateur")->first();


                        $user = User::where([
                            ["email", "=", $formateur->formateur],
                            ["type_id", "=", $formateurType->id]
                        ])->first();

                        if ($user) {

                            UserGroup::create([
                                "user_id" => $user->id,
                                "group_id" => $groupOBJ->id,
                            ]);
                        } else {

                            $user =  new User([
                                "email" => strtolower($formateur->formateur),
                                "username"=>strtolower($formateur->formateur),
                                "password" => strtolower($formateur->formateur),
                                "type_id" => $formateurType->id,
                            ]);
                            $groupOBJ->user()->save($user);
                        }
                    }
                }, $allFormateur);
            }, $AllGroups);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return back()->with("error", "quelque chose s'est mal passé");
        }

        return redirect("/");
    }
    public function DisactiveAll()
    {
        $type = Type::where("type_name", "formateur")->first();
        User::where("type_id", $type->id)->update([
            "active" => false
        ]);
        return back();
    }
    public function ActiveAll()
    {
        $type = Type::where("type_name", "formateur")->first();
        User::where("type_id", $type->id)->update([
            "active" => true
        ]);
        return back();
    }
}
