<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->foreignId('unidad_id')->constrained('unidades');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->decimal('dividendo', 10, 2)->default(1); // Divisor específico para cada producto
            $table->decimal('porcentaje_min', 5, 2)->default(0);
            $table->decimal('porcentaje_max', 5, 2)->default(0)->nullable();  // Puede ser nulo
            //$table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
