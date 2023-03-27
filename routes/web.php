<?php

use App\Http\Controllers\AspeetController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\uploadController;
use App\Http\Controllers\UserController;

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
Route::get('/', [HomeController::class,"GetDataAndDisplayIt"])->middleware("loginMiddleware")->name("home");
Route::get("/saveHomechanges",[HomeController::class,"SaveDonneChanges"])->name("saveHomeChanges");
//route login page
Route::get("/login",function(){
    return view("pages.login");
})->name("login");

//route upload page
Route::get("/upload",function(){
    return view("pages.upload");
})->middleware("uploadMiddleware")->name("upload");

//controller login when user logs in
Route::post("/Onlogin",[UserController::class,"login"])->name("Onlogin");
Route::get("/Onlogout",[UserController::class,"logout"])->name("Onlogout");

//controller upload when user upload a file
Route::post("/Onupload",[uploadController::class,"Onupload"])->name("Onupload");

//resource controller of Element
Route::resource('/Element',ElementController::class)->names([
    "show"=>"show"
])->middleware("loginMiddleware");

//resource controller of comments
Route::resource('/Comment',CommentsController::class)->names([
    "store"=>"store"
]);


//delete Comment
Route::get("/deleteComment/{Comment}/{id}",[UpdateController::class,"DeleteComment"])->name("deleteController");
Route::get("/updateComment/{Comment}/{id}",[UpdateController::class,"updateComment"])->name("updateController");

Route::get("/OnExport",[ExportController::class,"Export"])->name("OnExport");
