<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
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

//Open Routes
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"])->name('login');


//Protected Routes
Route::group(
    [
        "middleware" => ['auth:api', 'role']
    ],
    function () {
        Route::get('/residents', [ResidentController::class, 'index'])->middleware('scope:admin');
        Route::get('/residents/{resident}', [ResidentController::class, 'show'])->middleware('scope:admin');
        Route::post('/residents', [ResidentController::class, 'store'])->middleware('scope:admin');
        Route::put('/residents/{resident}', [ResidentController::class, 'update'])->middleware('scope:admin');
        Route::delete('/residents/{resident}', [ResidentController::class, 'destroy'])->middleware('scope:admin');

    }
);
