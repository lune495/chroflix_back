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
        Schema::table('histoires', function (Blueprint $table) {
            $table->string('image_couverture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('histoires', function (Blueprint $table) {
            //
             $table->dropForeign(['image_couverture']);
             $table->dropColumn('image_couverture');
        });
    }
};
