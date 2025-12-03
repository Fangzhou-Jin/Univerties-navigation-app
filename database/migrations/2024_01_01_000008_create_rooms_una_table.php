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
        Schema::create('rooms_una', function (Blueprint $table) {
            $table->id('id_room_una');
            $table->string('room_number_una', 255);
            $table->string('room_name_una', 255)->nullable();
            $table->integer('floor_number_una')->nullable();
            $table->string('directions_una', 255); 
            $table->unsignedBigInteger('id_university_una');
            $table->unsignedBigInteger('id_availability_una');
            $table->unsignedBigInteger('id_room_type_una');
            $table->unsignedBigInteger('id_building_una');
            
            // Foreign keys
            $table->foreign('id_university_una', 'FK_UniversityRooms')
                ->references('id_university_una')
                ->on('universities_una')
                ->onDelete('cascade');
            
            $table->foreign('id_availability_una', 'FK_AvailabilityRooms')
                ->references('id_availability_una')
                ->on('availability_una')
                ->onDelete('cascade');
            
            $table->foreign('id_room_type_una', 'FK_RoomTypeRooms')
                ->references('id_room_type_una')
                ->on('room_types_una')
                ->onDelete('cascade');
            
            $table->foreign('id_building_una', 'FK_BuildingRooms')
                ->references('id_building_una')
                ->on('buildings_una')
                ->onDelete('cascade');
            
            // Indexes
            $table->index('id_university_una');
            $table->index('id_availability_una');
            $table->index('id_room_type_una');
            $table->index('id_building_una');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_una');
    }
};

