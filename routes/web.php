<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//checar se o usuário está logado, caso não é redirecionado para o login
Route::middleware([CheckIsLogged::class])->group(function(){
    Route::get('/', [MainController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([CheckIsNotLogged::class])->group(function(){
    Route::get('/signup', [MainController::class, 'signup'])->name('signup');
    Route::post('/signup-submit', [AuthController::class, 'signUpSubmit'])->name('signUpSubmit');
    Route::get('/login', [MainController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
});

