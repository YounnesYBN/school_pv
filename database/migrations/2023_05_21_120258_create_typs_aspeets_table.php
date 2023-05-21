<?php

use App\Models\Aspeet;
use App\Models\Type;
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
        Schema::create('typs_aspeets', function (Blueprint $table) {
            $table->foreignId("type_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("aspeet_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typs_aspeets');
    }
};
