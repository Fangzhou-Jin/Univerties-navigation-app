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
        Schema::create('universities_una', function (Blueprint $table) {
            $table->id('id_university_una');
            $table->string('university_name_una', 255);
            $table->string('city_country', 255);
            $table->integer('population');
            $table->integer('post_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities_una');
    }
};

