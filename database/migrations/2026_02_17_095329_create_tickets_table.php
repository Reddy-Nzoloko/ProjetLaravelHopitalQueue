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
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        $table->integer('numero'); // ex: 1, 2, 3...
        $table->string('code_ticket'); // ex: PED-001
        $table->enum('statut', ['en_attente', 'appele', 'termine'])->default('en_attente');
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
