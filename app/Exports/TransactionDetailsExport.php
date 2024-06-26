<?php

namespace App\Exports;

use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionDetailsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactionId;

    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return TransactionDetail::where('transaction_id', $this->transactionId)->get();
    }

    /**
     * @var TransactionDetail $transactionDetail
     */
    public function map($transactionDetail): array
    {
        return [
            $transactionDetail->id,
            $transactionDetail->transaction_id,
            $transactionDetail->producto->nombre,
            $transactionDetail->cantidad,
            $transactionDetail->precio_compra_total,
            $transactionDetail->precio_venta_kilo_min,
            $transactionDetail->precio_venta_kilo_max,
            $transactionDetail->precio_general,
            $transactionDetail->created_at,
            $transactionDetail->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Transaction ID',
            'Producto',
            'Cantidad',
            'Precio Compra Total',
            'Precio Venta Kilo Min',
            'Precio Venta Kilo Max',
            'Precio General',
            'Creado En',
            'Actualizado En',
        ];
    }
}
