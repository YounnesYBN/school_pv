<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Element;
use App\Models\Filiere;
use App\Models\FormateurDonneeComment;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class FormateurCommentController extends Controller
{
    //
    public $deletedId;

    public function GetCommentAndDisplay(Group $group, Element $element, Filiere $filiere)
    {
        $allComments = [];
        $userOBJ = User::find(session("id"));
        $CommentObj = FormateurDonneeComment::where([
            ["group_id", "=", $group->id],
            ["element_id", "=", $element->id],
            ["user_id", "=", $userOBJ->id],
            ["filiere_id", "=", $filiere->id]
        ])->first();
        if ($CommentObj) {
            $allComments = json_decode($CommentObj->comments);
        }
        return view("pages.FormateurComment", [
            "group" => $group,
            "element" => $element,
            "filiere" => $filiere,
            "aspeet" => $element->aspeet()->first(),
            "comments" => $allComments,
            "commentOBJ" => isset($CommentObj) ? $CommentObj : null
        ]);
    }
    public function GetMaxIdDirecteurComment($values)
    {
        $newid = 0;
        foreach ($values as $value) {

            if ($newid < $value->id) {
                $newid = $value->id;
            };
        }
        return $newid;
    }
    public function GetMaxIdFormateurComment($values)
    {
        $newid = 0;
        foreach ($values as $value) {

            if ($newid < $value->origin_id) {
                $newid = $value->origin_id;
            };
        }
        return $newid;
    }

    public function AddComment(Request $request, Group $group, Element $element, Filiere $filiere)
    {

        $request->validate([
            "input_comment" => "required",
        ], [
            "input_comment.required" => "commentaire est requis",
        ]);
        $userOBJ = User::find(session("id"));

        $CommentObj = FormateurDonneeComment::where([
            ["group_id", "=", $group->id],
            ["element_id", "=", $element->id],
            ["user_id", "=", $userOBJ->id],
            ["filiere_id", "=", $filiere->id]
        ])->first();
        $newComment = [
            "active" => $request->checkbox_active == true ? true : false,
            "value" => $request->input_comment,
            "formateur" => $userOBJ->username,
            "group" => $group->name,
        ];
        try {
            //code...
            DB::beginTransaction();
            if ($CommentObj) {


                $commentJson = json_decode($CommentObj->comments);
                $newComment["origin_id"] = $this->GetMaxIdFormateurComment($commentJson) + 1;

                $commentJson[] = $newComment;
                $CommentObj->comments = json_encode($commentJson);
            } else {
                $CommentObj = new FormateurDonneeComment();
                $CommentObj->group_id = $group->id;
                $CommentObj->element_id = $element->id;
                $CommentObj->user_id = $userOBJ->id;
                $CommentObj->filiere_id = $filiere->id;
                $newComment["origin_id"] =  1;
                $CommentObj->comments =  json_encode([$newComment]);
            }
            $CommentObj->save();



            if ($request->checkbox_active) {

                $DirCommentObj = Comments::where([
                    ["filiere_id", "=", $filiere->id],
                    ["element_id", "=", $element->id],
                ])->first();
                if ($DirCommentObj) {
                    $commentJson = json_decode($DirCommentObj->value);
                    $newComment["id"] = $this->GetMaxIdDirecteurComment($commentJson) + 1;
                    $commentJson[] = $newComment;
                    $DirCommentObj->value = json_encode($commentJson);
                } else {
                    $DirCommentObj = new Comments();
                    $DirCommentObj->element_id = $element->id;
                    $DirCommentObj->filiere_id = $filiere->id;
                    $newComment["id"] =  1;
                    $DirCommentObj->value =  json_encode([$newComment]);
                }
                $DirCommentObj->save();
            }
            DB::commit();
            return redirect()->back()->with("success", "commentaire ajouté avec succès");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", "quelque chose s'est mal passé($th)");
        }
    }

    public function DeleteComment(FormateurDonneeComment $comment, $Id)
    {
        try {
            //code...
            DB::beginTransaction();
            $newdata = [];

            foreach (json_decode($comment->comments, true) as $value) {
                if ($value["origin_id"] != $Id) {
                    $newdata[] = $value;
                }
            }

            $comment->comments = json_encode($newdata);
            $comment->save();

            $newdataDir = [];
            $commentDirecteur = Comments::where([["filiere_id", "=", $comment->filiere_id], ["element_id", "=", $comment->element_id]])->first();
            if ($commentDirecteur) {
                foreach (json_decode($commentDirecteur->value, true) as $value) {
                    $isCommentFormateur = isset($value["origin_id"]);
                    if ($isCommentFormateur) {
                        if ($value["origin_id"] != $Id) {
                            $newdataDir[] = $value;
                        }
                    } else {
                        $newdataDir[] = $value;
                    }
                }
                $commentDirecteur->value = json_encode($newdataDir);
                $commentDirecteur->save();
            }
            DB::commit();
            return redirect()->back()->with("success", "commentaire supprimé avec succès");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", "quelque chose s'est mal passé ($th)");
        }
    }

    public function UpdateComment(Request $request, FormateurDonneeComment $comment, $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $isActive = isset($request->comment_checked) ? ($request->comment_checked == true ? true : false) : false;
            $newcomment = null;

            //change comment for formateur
            $newdata = [];
            foreach (json_decode($comment->comments, true) as $value) {
                if ($value["origin_id"] == $id) {
                    $value["active"] = $isActive;
                    $value["value"] = $request->comment_display_input;
                    $newdata[] = $value;
                    $newcomment = $value;
                } else {

                    $newdata[] = $value;
                }
            }
            $comment->comments = json_encode($newdata);
            $comment->save();

            //now for directeur
            if ($isActive) {
                //on active we check if formateur is updated only comment or both

                $commentDirObj = Comments::where([["filiere_id", "=", $comment->filiere_id], ["element_id", "=", $comment->element_id]])->first();
                $allcomments = json_decode($commentDirObj->value);
                $isExist = false;
                foreach ($allcomments as $ele) {
                    if (isset($ele->origin_id) && $ele->origin_id == $id) {
                        $isExist = true;
                    }
                }
                if ($isExist) {
                    //here already exists only update value
                    foreach ($allcomments as $ele) {
                        if (isset($ele->origin_id) && $ele->origin_id == $id) {
                            $ele->value = $request->comment_display_input;

                        }
                    }
                    

                } else {
                    //here that comment is not exsist but existes on fromateur but was unactive but it active so make new one for directeur  

                    $newcomment["id"] = $this->GetMaxIdDirecteurComment($allcomments) + 1;
                    $allcomments[] = $newcomment;
                }

                //save changes
                $commentDirObj->value  = json_encode($allcomments);
                $commentDirObj->save();
            } else {
                //on disactive we delete it from directeur comments
                $commentDirObj = Comments::where([["filiere_id", "=", $comment->filiere_id], ["element_id", "=", $comment->element_id]])->first();
                $newcommentDir = [];
                foreach (json_decode($commentDirObj->value, true) as $value) {
                    if (isset($value["origin_id"])) {
                        if ($value["origin_id"] != $id) {
                            $newcommentDir[] = $value;
                        }
                    } else {
                        $newcommentDir[] = $value;
                    }
                }
                $commentDirObj->value = json_encode($newcommentDir);
                $commentDirObj->save();
            }

            DB::commit();
            return  back()->with("success", "commentaires mis à jour avec succès");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", "quelque chose s'est mal passé ($th)");
        }
    }
}
