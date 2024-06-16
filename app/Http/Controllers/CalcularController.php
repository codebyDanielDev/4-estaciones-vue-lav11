<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CalcularController extends Controller
{
    public function index()
    {
        return Inertia::render('App/Calculate/Index');
    }
}
