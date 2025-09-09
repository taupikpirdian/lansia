<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        // redirect to dashboard
        return view('welcome');
    }
}
