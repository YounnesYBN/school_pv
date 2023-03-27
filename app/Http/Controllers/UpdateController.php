<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;



class UpdateController extends Controller
{
    //


    public function DeleteComment(Request $r, Comments $Comment, $id)
    {

        $array_comments = json_decode($Comment->value);
        $newArray = array();
        foreach ($array_comments as $value) {
            if ($value->id != $id) {
                $newArray[] = $value;
            }
        }

        $Comment->value = json_encode($newArray);
        $Comment->save();

        return back();
    }

    public function SaveChanges(Request $Request)
    {
        $commentId = $Request->id_comment;
        $changes = $Request->data;
        
        
        $comment = Comments::all()->where("id", $commentId)->first();
        $commentarray = json_decode($comment->value);
        
        foreach ($commentarray as $comment_ele) {
            foreach ($changes as $change) {
                
                if ($comment_ele->id == $change["id"]) {
                    $comment_ele->active = $change["active"];
                }
            }
        }
        
        $comment->value = json_encode($commentarray);
        $comment->save();
        return response(200);
    }

    public function UpdateComment(Request $r,Comments $Comment,string $updated_comment){
        
        $r->validate([
             "comment_display_input"=>["required"]
        ]);

        
        $array_comments = json_decode($Comment->value);
        
        foreach ($array_comments as $value) {
            if ($value->id == $updated_comment) {
                $value->value = $r->comment_display_input;
            }
        }

        $Comment->value = json_encode($array_comments);
        $Comment->save();

        return back();
    }
}
