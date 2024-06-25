<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        return Inertia::render('App\History\Index.vue');
    }
}
