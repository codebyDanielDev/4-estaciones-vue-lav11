<?php

namespace App\Http\Controllers;

use App\Models\HistorialPrecio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
class HistoryController extends Controller
{
    public function index()
    {
        $historialPrecios = HistorialPrecio::with(['producto', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($historial) {
                // Formatea el campo created_at con Carbon
                $historial->formatted_created_at = Carbon::parse($historial->created_at)->format('d/m/Y H:i');
                return $historial;
            });

        return Inertia::render('App/History/Index', [
            'historialPrecios' => $historialPrecios,
        ]);
    }
    
}
