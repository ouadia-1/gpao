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
        Schema::create('o_f_s', function (Blueprint $table) {
            $table->string('numero_of')->primary(); // Utilisez le numéro d'OF comme clé primaire
            $table->string('client');
            $table->string('designation');
            $table->integer('qte');
            $table->string('caracteristiques');
            $table->string('etat');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('o_f_s');
    }
};
