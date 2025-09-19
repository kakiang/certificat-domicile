<?php

use App\Models\Certificat;
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
        Schema::create('certificat_delivres', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Certificat::class)->constrained()->onDelete('cascade');
            $table->string('numero_certificat')->unique();
            $table->string('code_secret')->unique();
            $table->string('habitant_id');
            $table->string('habitant_nom');
            $table->string('habitant_prenom');
            $table->string('habitant_telephone');
            $table->date('habitant_date_naissance');
            $table->string('habitant_lieu_naissance');

            $table->string('habitant_maison_adresse');
            $table->string('habitant_maison_proprietaire');
            $table->string('habitant_maison_quartier_nom');
            $table->timestamp('date_demande');
            $table->timestamp('date_delivrance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificat_delivres');
    }
};
