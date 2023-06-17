<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class FormateurProfileController extends Controller
{
    //
    public function edite()
    {
        $user = User::find(session("id"));


        return view("pages.formateurProfile", ["user" => $user]);
    }

    public function update(Request $request)
    {
        $user =  User::find(session("id"));
        $request->validate([
            "username" => ["required", "unique:users,username," . $user->id],
            "email" => ["required", "unique:users,email," . $user->id],
            "password" => ["required", "confirmed"]

        ], [
            "username.unique" => "ce nom d'utilisateur existe déjà",
            "username.required" => "Entrez un nom d'utilisateur",
            "email.unique" => "ce email existe déjà",
            "email.required" => "Entrez un email ",
            "password.required" => "Entrez un mot de passe",
            "password.confirmed" => "s'il te plaît confirmer votre mot de passe"
        ]);
        try {
            DB::beginTransaction();



            $user->update([
                "username" => $request->username,
                "email" => $request->email,
                "password" => $request->password,
            ]);
            session("email",$user->email);
            DB::commit();
            return back()->with("success","informations de profil mises à jour avec succès");
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error","quelque chose s'est mal passé");

        }
    }
}
