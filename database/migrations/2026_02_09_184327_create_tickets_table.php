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
        Schema::create('tickets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('hopital_id')->constrained('hopitaux');
    $table->foreignId('service_id')->constrained('services');
    $table->foreignId('guichet_id')->nullable()->constrained('guichets');
    $table->foreignId('user_id')->nullable()->constrained('users'); // Le médecin qui traite le patient

    $table->string('numero_ticket'); // ex: PED-001
    $table->integer('priorite')->default(0); // 0: Normal, 1: Urgent
    $table->enum('statut', ['en_attente', 'appelé', 'en_consultation', 'terminé', 'absent'])->default('en_attente');

    $table->timestamp('heure_arrivee')->useCurrent();
    $table->timestamp('heure_appel')->nullable(); // Moment du passage au haut-parleur
    $table->timestamp('heure_debut')->nullable(); // Début réel du soin
    $table->timestamp('heure_fin')->nullable();   // Fin du soin
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
