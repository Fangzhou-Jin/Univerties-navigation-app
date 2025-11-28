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
        Schema::create('departments_una', function (Blueprint $table) {
            $table->id('id_department_una');
            $table->string('department_name_una', 255);
            $table->unsignedBigInteger('id_university_una');
            $table->timestamps();
            
            // Foreign key
            $table->foreign('id_university_una', 'FK_UniversityDepartment')
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
        Schema::dropIfExists('departments_una');
    }
};

