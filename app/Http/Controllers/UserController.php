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
            $user = User::all()->where('email', $request->input("email"))->where("password", $request->password)->first();

            if ($user) {
                $type = $user->type()->first()->type_name;
                if ($type == "directeur") {
                    session([
                        "type" => $user->type()->first()->type_name,
                        "id" => $user->id,
                        "email" => $user->email,
                    ]);
                    return redirect("/");
                } elseif ($type == "formateur") {
                    if($user->active == true){
                        session([
                            "type" => $user->type()->first()->type_name,
                            "id" => $user->id,
                            "email" => $user->email,
                        ]);
                        return redirect("/FormateurHome");
                    }else{
                        return back()->with("error", "la connexion a échoué, votre compte est désactivé");
                    }
                }


                
            } else {
                return back()->with("error", "la connexion a échoué, les informations ne sont pas correctes");
            }
        } catch (\Throwable $th) {

            return back()->with("error", "quelque chose s'est mal passé");
        }
    }

    public function logout()
    {

        session()->flush();

        return redirect("login");
    }
}
