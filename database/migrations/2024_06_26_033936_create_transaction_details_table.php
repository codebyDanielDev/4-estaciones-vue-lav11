<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions');
            $table->foreignId('producto_id')->constrained('productos');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_compra_total', 10, 2);
            $table->decimal('precio_venta_kilo_min', 10, 2)->nullable();
            $table->decimal('precio_venta_kilo_max', 10, 2)->nullable();
            $table->decimal('precio_general', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
