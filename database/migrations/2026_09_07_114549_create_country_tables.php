<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('badge', 500);
            $table->string('name', 50)->index('idx_county_name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->integer('zip_code', false, false)->index('idx_zip_code');
            $table->string('city', 50)->index('idx_city');
            $table->integer('population');
            $table->foreignId('id_county')->constrained('counties')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('counties');
    }
};
