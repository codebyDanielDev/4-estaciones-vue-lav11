<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialPreciosTable extends Migration
{
    public function up()
    {
        Schema::create('historial_precios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos');
            
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('precio_compra_total', 10, 2)->check('precio_compra >= 0'); //acá será para el precio total bruto
            $table->decimal('cantidad', 10, 2)->check('cantidad >= 0');
            $table->decimal('precio_compra_producto', 10, 2)->check('cantidad >= 0'); //acá será el precio por caja/paquete/ etc
            $table->decimal('dividendo', 10, 2)->default(1); // Divisor específico para cada producto
            $table->decimal('porcentaje_min', 5, 2)->default(0);
            $table->decimal('porcentaje_max', 5, 2)->default(0)->nullable();
            $table->decimal('precio_venta', 10, 2)->check('precio_venta >= 0');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_precios');
    }
}

