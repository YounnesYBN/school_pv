<?php

use App\Http\Controllers\UpdateController;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//save changes
Route::post("/saveChanges", [UpdateController::class, "SaveChanges"]);

//change year
Route::get("/changeYear/{year}", function ($year) {

    $data = Filiere::where("annee", $year)->orderByDesc('id')->get();

    return response()->json([
        "filiere" => $data
    ]);
});
