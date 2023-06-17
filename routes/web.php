<?php

use App\Http\Controllers\AccountesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportTableController;
use App\Http\Controllers\FormateurCommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\uploadController;
use App\Http\Controllers\UserController;
use App\Models\AccouteFiliereData;
use App\Models\Aspeet;
use App\Models\Element;
use App\Models\Export;
use App\Models\Filiere;
use App\Models\Group;
use App\Models\Type;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormateurHomeController;
use App\Http\Controllers\FormateurProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//route home page
Route::get('/', [HomeController::class, "GetDataAndDisplayIt"])->middleware("directeur_middleware")->name("home");
Route::get("/saveHomechanges", [HomeController::class, "SaveDonneChanges"])->middleware("directeur_middleware")->name("saveHomeChanges");
//route login page
Route::get("/login", function () {
    return view("pages.login");
})->name("login");
//route upload page
Route::get("/upload", function () {
    return view("pages.upload");
})->middleware("directeur_middleware")->name("upload");
//controller login when user logs in
Route::post("/Onlogin", [UserController::class, "login"])->name("Onlogin");
Route::get("/Onlogout", [UserController::class, "logout"])->name("Onlogout");
//resource controller of Element
Route::resource('/Element', ElementController::class)->names([
    "show" => "show"
])->middleware("loginMiddleware");
//resource controller of comments
Route::resource('/Comment', CommentsController::class)->names([
    "store" => "store"
])->middleware("loginMiddleware");
//delete Comment
Route::get("/deleteComment/{Comment}/{id}", [UpdateController::class, "DeleteComment"])->middleware("loginMiddleware")->name("deleteController");
Route::get("/updateComment/{Comment}/{id}", [UpdateController::class, "updateComment"])->middleware("loginMiddleware")->name("updateController");
//controller upload when user upload a file
Route::post("/Onupload", [uploadController::class, "Onupload"])->middleware("directeur_middleware")->name("Onupload");
Route::get("/OnExport", [ExportController::class, "Export"])->middleware("directeur_middleware")->name("OnExport");
//history of all exports the user made
Route::get("/Exports", function () {
    $allExports = Export::all();
    return view("pages.exports", ["data" => $allExports]);
})->middleware("directeur_middleware")->name("exports");

Route::get("Exports/delete/{id}", [ExportTableController::class, "deleteExport"])->middleware("directeur_middleware")->name("deleteExport");
Route::get("Exports/export/{id}", [ExportTableController::class, "export"])->middleware("directeur_middleware")->name("ExportData");
//accounts
Route::get("Accountes", [AccountesController::class, "AccounteIndex"])->middleware("directeur_middleware")->name("accountes");
Route::post("OnUploadAccounts&Filiere", [AccountesController::class, "OnUpload"])->middleware("directeur_middleware")->name("uploadAccount&filiere");
Route::get("deleteFormateur/{id}",[AccountesController::class,"deleteFormateur"])->middleware("directeur_middleware")->name("deleteFormateur");
Route::get("activeFormateur/{id}",[AccountesController::class,"ActiveFormateur"])->middleware("directeur_middleware")->name("activeFormateur");
Route::get("disactiveFormateur/{id}",[AccountesController::class,"DisActiveFormateur"])->middleware("directeur_middleware")->name("disactiveFormateur");
Route::get("disactiveAll",[AccountesController::class,"DisactiveAll"])->middleware("directeur_middleware")->name("disactiveAllFormateur");
Route::get("activeAll",[AccountesController::class,"ActiveAll"])->middleware("directeur_middleware")->name("activeAllFormateur");


//formateur----------------------------------------------------------------------------------------------------
Route::get("FormateurHome",[FormateurHomeController::class,"GetDataAndDisplayIt"])->middleware("loginMiddleware")->name("formateurHome");
Route::get("FormateurComment/{group}/{element}/{filiere}",[FormateurCommentController::class,"GetCommentAndDisplay"])->middleware("loginMiddleware")->name("FormateurComment");
Route::post("AddCommentFormateur/{group}/{element}/{filiere}",[FormateurCommentController::class,"AddComment"])->middleware("loginMiddleware")->name("FormateurCommentAdd");
Route::get("DeleteCommentFormateur/{comment}/{id}",[FormateurCommentController::class,"DeleteComment"])->middleware("loginMiddleware")->name("FormateurCommentDelete");
Route::post("UpdateCommentFormateur/{comment}/{id}",[FormateurCommentController::class,"UpdateComment"])->middleware("loginMiddleware")->name("FormateurCommentUpdate");
Route::get("FormateurProfile",[FormateurProfileController::class,"edite"])->middleware("loginMiddleware")->name("FormateurProfile");
Route::put("updateProfile",[FormateurProfileController::class,"update"])->middleware("loginMiddleware")->name("updateProfile");
Route::get("/GetGroups/{filiere}",function($filiere){
    $user = User::where("email",session("email"))->first();
    // $groups = $user->group()->get();
    $groups = $user->group()->where("filiere_id",Filiere::where("code_filiere",$filiere)->first()->id)->get();
    return response()->json([
        "data"=>$groups
    ]);
});