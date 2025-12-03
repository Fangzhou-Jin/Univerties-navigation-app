<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'room_types_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_room_type_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'room_type_una',
    ];

    /**
     * Get the rooms for the room type.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'id_room_type_una', 'id_room_type_una');
    }
}

