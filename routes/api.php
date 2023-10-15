<?php

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HorarioController;
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

Route::get("/usuarios", [UsuarioController::class, "index"]);
Route::get("/usuarios/{id}", [UsuarioController::class, "show"]);
Route::post("/usuarios", [UsuarioController::class, "store"]);
Route::put("/usuarios/{id}", [UsuarioController::class, "update"]);
Route::delete("/usuarios/{id}", [UsuarioController::class, "destroy"]);

Route::get("/horarios/{fecha}", [HorarioController::class, "horarios"]);
Route::post("/cita", [CitaController::class, "store"]);
