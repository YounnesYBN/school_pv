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
        Schema::create('formateur_donnee_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("filiere_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("group_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("element_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer("donnee")->default(0);
            $table->json("comments")->default(json_encode([]));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formateur_donnee_comments');
    }
};
