<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CalcularController extends Controller
{
    public function index()
    {
        //resources/js/Pages/App/Calculate/Index.vue
        return Inertia::render('App/Calculate/Index');
    }
}
