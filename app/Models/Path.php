<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Path extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'paths_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_path_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_room_point_a_una',
        'id_room_point_b_una',
        'walking_distance_meters',
        'estimated_time_minutes',
    ];

    /**
     * Get the starting room (Point A).
     */
    public function roomA(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'id_room_point_a_una', 'id_room_una');
    }

    /**
     * Get the destination room (Point B).
     */
    public function roomB(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'id_room_point_b_una', 'id_room_una');
    }
}

