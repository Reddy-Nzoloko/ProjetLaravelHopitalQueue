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
       Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->foreignId('hopital_id')->constrained('hopitaux')->onDelete('cascade');
    $table->string('nom'); // ex: Pédiatrie, Ophtalmologie
    $table->string('prefixe', 5); // ex: "PED" pour les tickets de pédiatrie
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
