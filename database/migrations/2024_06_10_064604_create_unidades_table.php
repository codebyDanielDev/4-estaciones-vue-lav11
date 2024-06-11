<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();
            $table->string('acronimo', 10)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidades');
    }
}

