<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ElementController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Element $Element)
    {

        $Selected_comment = null;
        //
        $all_Comments = $Element->comment()->get();

        foreach ($all_Comments as $comment) {
            $filier_comment = $comment->filiere()->first();

            if (
                $filier_comment->code_filiere == session("selected_filier") &&
                $filier_comment->annee == session("selected_year")
            ) {
                $Selected_comment = $comment;
            }
        }
        session([
            "selected_element" => $Element->id,
            "selected_comment" => $Selected_comment?$Selected_comment->id:null,
        ]);
        
        if ($Selected_comment) {
            return view("pages.comment", [
                "data" => [
                    "found" => true,
                    "elementOBJ" => $Element,
                    "commentOBJ" => $Selected_comment,
                    "aspeetOBJ" =>$Element->aspeet()->first()
                ],
                "comments" => (array) json_decode($Selected_comment->value)
            ]);
        } else {
            return view("pages.comment", [
                "data" => [
                    "found" => true,
                    "elementOBJ" => $Element,
                    "commentOBJ" => null,
                    "aspeetOBJ" =>$Element->aspeet()->first()


                ],
                "comments" => []

            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Element $element)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Element $element)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Element $element)
    {
        //
    }
}
