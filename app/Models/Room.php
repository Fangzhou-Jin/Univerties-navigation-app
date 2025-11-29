<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'rooms_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_room_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'room_number_una',
        'room_name_una',
        'floor_number_una',
        'id_university_una',
        'id_availability_una',
        'id_room_type_una',
        'id_building_una',
    ];

    /**
     * Get the university that owns the room.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'id_university_una', 'id_university_una');
    }

    /**
     * Get the availability status of the room.
     */
    public function availability(): BelongsTo
    {
        return $this->belongsTo(Availability::class, 'id_availability_una', 'id_availability_una');
    }

    /**
     * Get the room type.
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'id_room_type_una', 'id_room_type_una');
    }

    /**
     * Get the building that owns the room.
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'id_building_una', 'id_building_una');
    }

    /**
     * Get paths where this room is point A.
     */
    public function pathsFromHere(): HasMany
    {
        return $this->hasMany(Path::class, 'id_room_point_a_una', 'id_room_una');
    }

    /**
     * Get paths where this room is point B.
     */
    public function pathsToHere(): HasMany
    {
        return $this->hasMany(Path::class, 'id_room_point_b_una', 'id_room_una');
    }
}

