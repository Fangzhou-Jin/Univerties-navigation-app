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
        Schema::create('buildings_una', function (Blueprint $table) {
            $table->id('id_building_una');
            $table->string('building_code_una', 255)->nullable();
            $table->string('building_name_una', 255)->nullable();
            $table->unsignedBigInteger('id_university_una');
            $table->timestamps();
            
            // Foreign key
            $table->foreign('id_university_una', 'FK_UniversityBuildings')
                ->references('id_university_una')
                ->on('universities_una')
                ->onDelete('cascade');
            
            // Index
            $table->index('id_university_una');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings_una');
    }
};

