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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');

        // --- NOS AJOUTS POUR L'HÔPITAL ---
        // On lie l'utilisateur à un hôpital (nullable pour les admins globaux)
        $table->foreignId('hopital_id')->nullable()->constrained('hopitaux')->onDelete('cascade');

        // On définit le rôle de l'utilisateur
        $table->enum('role', ['admin_global', 'admin_hopital', 'medecin', 'receptionniste'])->default('medecin');

        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
