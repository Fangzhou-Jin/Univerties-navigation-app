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
        Schema::create('paths_una', function (Blueprint $table) {
            $table->id('id_path_una');
            $table->unsignedBigInteger('id_room_point_a_una');
            $table->unsignedBigInteger('id_room_point_b_una');
            $table->integer('walking_distance_meters');
            $table->integer('estimated_time_minutes');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('id_room_point_a_una', 'FK_RoomAPath')
                ->references('id_room_una')
                ->on('rooms_una')
                ->onDelete('cascade');
            
            $table->foreign('id_room_point_b_una', 'FK_RoomBPath')
                ->references('id_room_una')
                ->on('rooms_una')
                ->onDelete('cascade');
            
            // Indexes
            $table->index('id_room_point_a_una');
            $table->index('id_room_point_b_una');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paths_una');
    }
};

