<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class HistoryPanelController extends Controller
{
    public function history()
    {
        return Inertia::render('App/History/Index');
    }

    public function fetchTransactions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'perPage' => 'integer|min:1|max:100',
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Parámetros inválidos.',
                'messages' => $validator->errors()
            ], 422);
        }

        try {
            $perPage = $request->get('perPage', 10); // Número inicial de elementos por página
            $page = $request->get('page', 1); // Página actual

            $transactions = $this->getTransactions($perPage, $page);

            return response()->json([
                'transactions' => $transactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al cargar el historial de transacciones. Inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    private function getTransactions($perPage, $page)
    {
        return Transaction::with(['details.producto', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
