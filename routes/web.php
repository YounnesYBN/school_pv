<?php

use App\Http\Controllers\AccountesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportTableController;
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
Route::get('/', [HomeController::class, "GetDataAndDisplayIt"])->middleware("loginMiddleware")->name("home");
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

Route::get("FormateurHome",function(){ 
    return view("pages.formateurHome");
})->middleware("loginMiddleware")->name("formateurHome");