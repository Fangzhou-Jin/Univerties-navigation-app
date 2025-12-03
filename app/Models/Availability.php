<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Availability extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'availability_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_availability_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'availability_una',
    ];

    /**
     * Get the rooms for the availability status.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'id_availability_una', 'id_availability_una');
    }
}

