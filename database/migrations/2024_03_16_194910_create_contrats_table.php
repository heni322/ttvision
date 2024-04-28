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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('type_contrat_id')->nullable();
            $table->foreign('type_contrat_id')->references('id')->on('contrat_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->dropForeign(['type_contrat_id']);
            $table->dropColumn('type_contrat_id');
        });
        Schema::dropIfExists('contrats');
    }
};
