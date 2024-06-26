<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PDFController extends Controller
{
    public function generarPDF()
    {
        $data = ['title' => 'PDF generado desde Laravel y Vue 3'];
        $pdf = Pdf::loadView('pdf.vista_pdf', $data);

        return $pdf->download('archivo.pdf');
    }
}
