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
        Schema::create('historial_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('precio_anterior', 10, 2);
            $table->decimal('precio_nuevo', 10, 2);
            $table->decimal('cantidad', 10, 2)->check('cantidad >= 0');
            $table->decimal('dividendo', 10, 2)->check('dividendo >= 0');
            $table->decimal('porcentaje_min', 5, 2)->default(0);
            $table->decimal('porcentaje_max', 5, 2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_productos');
    }
};
