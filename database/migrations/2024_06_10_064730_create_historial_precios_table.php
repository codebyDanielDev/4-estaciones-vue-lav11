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
            $table->decimal('precio_compra', 10, 2)->check('precio_compra >= 0');
            $table->decimal('cantidad', 10, 2)->check('cantidad >= 0');
            $table->decimal('dividendo', 10, 2)->check('dividendo >= 0');
            $table->decimal('porcentaje', 5, 2)->check('porcentaje >= 0');
            $table->decimal('precio_venta', 10, 2)->check('precio_venta >= 0');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_precios');
    }
}

