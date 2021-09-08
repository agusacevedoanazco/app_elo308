<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();

            $table->string('oc_publication_id')->unique();
            $table->string('360p-quality_url');
            $table->string('480p-quality_url')->nullable();
            $table->string('720p-quality_url');
            $table->string('1080p-quality_url')->nullable();
            $table->string('2160p-quality_url')->nullable();
            $table->string('mediatype');

            $table->foreignId('id_evento')->constrained('eventos')->cascadeOnDelete();

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
        Schema::dropIfExists('publicaciones');
    }
}
