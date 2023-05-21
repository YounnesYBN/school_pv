<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    //

    public function login(Request $request)
    {


        $request->validate([
            "email" => "required",
            "password" => "required",
        ], [
            "email" => "nom est requis",
            "password" => "mot de pass est requis",
        ]);

        try {
            //code...
            //throw $th;
            $check = User::all()->where('email', $request->input("email"))->where("password", $request->password)->first();

            if ($check) {
                // return dd();
                session([
                    "type" => $check->type()->first()->type_name,
                    "id" => $check->id,
                    "email" => $check->email,
                ]);

                return redirect("/");
            } else {
                return back()->with("error", "la connexion a échoué, les informations ne sont pas correctes");
            }
        } catch (\Throwable $th) {

            return back()->with("error","quelque chose s'est mal passé");
        }
    }

    public function logout()
    {

        session()->flush();

        return redirect("login");
    }
}
