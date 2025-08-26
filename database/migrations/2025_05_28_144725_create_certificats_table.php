<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificats', function (Blueprint $table) {
            $table->id();
            $table->string('numero_certificat')->unique()->nullable();
            $table->dateTime('date_demande')->useCurrent();
            $table->dateTime('date_delivrance')->nullable();
            $table->foreignId('habitant_id')->constrained();
            $table->string('piece_identite')->nullable();
            $table->string('piece_identite_file_path')->nullable();
            $table->string('piece_identite_slug')->nullable();
            $table->string('justificatif_domicile')->nullable();
            $table->string('justificatif_domicile_file_path')->nullable();
            $table->string('justificatif_domicile_slug')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->enum('status', ['En attente', 'En cours de traitement', 'Incomplète', 'Délivré', 'Rejété'])->default('En attente');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificats');
    }
};
