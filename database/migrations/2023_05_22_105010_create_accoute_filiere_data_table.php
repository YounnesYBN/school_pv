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
        Schema::create('accoute_filiere_data', function (Blueprint $table) {
            $table->id();
            $table->string("formateur");
            $table->string("mat");
            $table->string("group");
            $table->string("filiere_code");
            $table->string("filiere_name");
            $table->string("year");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accoute_filiere_data');
    }
};
