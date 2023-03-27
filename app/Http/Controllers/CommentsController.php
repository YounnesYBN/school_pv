<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_element = session("selected_element");
        $id_filier = Filiere::where([
            ["code_filiere","=",session("selected_filier")],
            ["annee","=",session("selected_year")]
        ])->first()->id;
        $active = $request->checkbox_active ? true : false;

        $request->validate([
            "input_comment" => "required",
        ],[
            "input_comment" => [
                "required" => "un commentaire est requis"
            ]
        ]);

        $comment = Comments::where([
            ["filiere_id","=",$id_filier],
            ["element_id","=",$id_element],
        ])->first();

        if($comment){
            $newid = 0;
            $values = json_decode($comment->value);
            foreach ($values as $value) {
                if($newid < $value->id){
                    $newid = $value->id; 
                };
            }
            $values[] = ["id"=>$newid + 1 ,"value"=>$request->input_comment,"active"=>$active];
            $comment->value = json_encode($values);
        }else{
            $comment = new Comments();
            $comment->filiere_id = $id_filier;
            $comment->element_id = $id_element;
            $comment->value = json_encode([[
                "id"=> 1 ,"value"=>$request->input_comment,"active"=>$active
            ]]);

        }
        $comment->save();
        return back();

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
