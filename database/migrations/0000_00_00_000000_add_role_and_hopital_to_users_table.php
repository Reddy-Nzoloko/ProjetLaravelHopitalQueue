<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajout du rôle : super_admin, admin_hopital, ou medecin
            $table->enum('role', ['super_admin', 'admin_hopital', 'medecin'])->default('medecin')->after('password');

            // Ajout du lien vers l'hôpital
            $table->foreignId('hopital_id')->nullable()->after('role')->constrained('hopitaux')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On retire la contrainte avant de supprimer la colonne
            $table->dropForeign(['hopital_id']);
            $table->dropColumn(['role', 'hopital_id']);
        });
    }
};
