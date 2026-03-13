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
        Schema::table('guichets', function (Blueprint $table) {
            // a guichet est désormais rattaché à un service (optionnel pour rétrocompatibilité)
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guichets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_id');
        });
    }
};
