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
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('patient_nom')->nullable()->after('numero_ticket');
            $table->string('patient_telephone')->nullable()->after('patient_nom');
            $table->string('patient_email')->nullable()->after('patient_telephone');
            $table->unsignedInteger('patient_age')->nullable()->after('patient_email');
            $table->enum('patient_sexe', ['M', 'F', 'X'])->nullable()->after('patient_age');
        });

        Schema::table('guichets', function (Blueprint $table) {
            $table->unsignedInteger('delai_appel')->default(30)->after('est_ouvert');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'patient_nom',
                'patient_telephone',
                'patient_email',
                'patient_age',
                'patient_sexe',
            ]);
        });

        Schema::table('guichets', function (Blueprint $table) {
            $table->dropColumn('delai_appel');
        });
    }
};
