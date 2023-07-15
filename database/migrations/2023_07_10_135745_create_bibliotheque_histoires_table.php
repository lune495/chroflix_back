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
        Schema::create('bibliotheque_histoires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('histoire_id');
            $table->foreign('histoire_id')->references('id')->on('histoires');
            $table->unsignedBigInteger('bibliotheque_id');
            $table->foreign('bibliotheque_id')->references('id')->on('bibliotheques');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliotheque_histoires');
    }
};
