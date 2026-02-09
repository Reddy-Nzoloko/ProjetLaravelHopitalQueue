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
    Schema::create('consultations', function (Blueprint $table) {
        $table->id();

        // Lien avec le ticket (Une consultation appartient à un ticket spécifique)
        $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');

        // Informations médicales
        $table->text('symptomes')->nullable();
        $table->text('diagnostic')->nullable();
        $table->text('ordonnance')->nullable(); // Liste des médicaments
        $table->text('notes_privees')->nullable(); // Notes pour le médecin uniquement

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
