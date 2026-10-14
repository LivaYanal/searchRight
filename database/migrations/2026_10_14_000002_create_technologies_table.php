<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Programmeertalen en frameworks, bijv. PHP, C#, JavaScript
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Koppeltabel: een bedrijf heeft meerdere technologieën,
        // en een technologie hoort bij meerdere bedrijven (many-to-many)
        Schema::create('company_technology', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $table->primary(['company_id', 'technology_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_technology');
        Schema::dropIfExists('technologies');
    }
};
