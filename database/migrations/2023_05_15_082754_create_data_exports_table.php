<?php

use App\Models\Export;
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
        Schema::create('data_exports', function (Blueprint $table) {
            $table->id();
            $table->string("code_filiere");
            $table->string("filiere_nom");
            $table->string("annee");
            $table->string("elements_de_traitement");
            $table->string("aspeets_tailer");
            $table->string("donnees");
            $table->text("commentaires");
            $table->string("group");
            $table->string("person");
            $table->foreignId("export_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_exports');
    }
};
