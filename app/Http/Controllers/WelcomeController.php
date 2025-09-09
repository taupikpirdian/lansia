<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class WelcomeController extends Controller
{
    public function index()
    {
        // redirect to dashboard
        // sliders data, limit 3
        $sliders = Slider::limit(3)->get();
        return view('welcome', compact('sliders'));
    }
}