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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // nouveau livre,nouveau chapitre,commentaire,vote
            $table->text('contenu');
            $table->boolean('lue')->default(false);

            // Ajoute une clé étrangère vers l'utilisateur ou l'auteur
            $table->unsignedBigInteger('utilisateur_destinataire_id')->nullable();
            $table->unsignedBigInteger('auteur_destinataire_id')->nullable();
            $table->foreign('utilisateur_destinataire_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('auteur_destinataire_id')->references('id')->on('auteurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
