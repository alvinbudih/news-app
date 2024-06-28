<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
  Route::get("/users", [UserController::class, "index"]);

  Route::get("/news", [NewsController::class, "index"]);
  Route::post("/news", [NewsController::class, "store"]);
  Route::get("/news/{id}", [NewsController::class, "show"]);
  Route::get("/news/{id}/pdf", [NewsController::class, "exportPdf"]);
  Route::put("/news/{id}", [NewsController::class, "update"]);
  Route::delete("/news/{id}", [NewsController::class, "destroy"]);

  Route::get("/logs", LogController::class);

  Route::post("/logout", [UserController::class, "logout"]);
});

Route::post("/register", [UserController::class, "create"]);
Route::post("/login", [UserController::class, "login"]);
