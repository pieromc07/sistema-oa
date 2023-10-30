<?php

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
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

Route::post("/login", [LoginController::class, "loginApiClient"]);
Route::get("/horarios/{fecha}", [HorarioController::class, "horarios"]);
Route::post("/cita", [CitaController::class, "store"]);
Route::get("/citas/cliente/{id}", [CitaController::class, "citasCliente"]);
