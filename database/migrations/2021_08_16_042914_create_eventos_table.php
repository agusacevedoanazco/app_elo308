<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('evento_oc')->nullable()->unique();
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('temp_filename')->nullable();
            $table->string('temp_directory')->nullable();
            $table->string('autor');
            $table->boolean('pendiente')->default(false);
            $table->boolean('error')->default(false);
            $table->foreignId('id_asignatura')->constrained('asignaturas')->cascadeOnDelete();
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
        Schema::dropIfExists('eventos');
    }
}
