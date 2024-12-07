<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function home(){
        return Inertia::render('Home');
    }

    public function signup() {
        return Inertia::render('Signup');
    }

    public function login(){
        return Inertia::render('Login');
    }
}
