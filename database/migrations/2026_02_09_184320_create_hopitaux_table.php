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
        Schema::create('hopitaux', function (Blueprint $table) {
    $table->id();
    $table->string('nom'); // Nom de l'hôpital (ex: Hopital Provincial)
    $table->string('adresse')->nullable();
    $table->string('code_unique')->unique(); // Pour identifier l'hôpital dans l'URL
    $table->json('configuration')->nullable(); // Pour stocker les réglages (ex: voix du haut-parleur)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hopitaux');
    }
};
