<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();

            $table->string('oc_series_id')->unique();
            $table->string('oc_series_name')->unique();

            $table->string('nombre');
            $table->integer('anio');
            $table->integer('semestre');
            $table->integer('paralelo');
            $table->string('codigo',6);

            $table->foreignId('id_departamento')->constrained('departamentos')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaturas');
    }
}
