<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'buildings_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_building_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'building_code_una',
        'building_name_una',
        'id_university_una',
    ];

    /**
     * Get the university that owns the building.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'id_university_una', 'id_university_una');
    }

    /**
     * Get the rooms for the building.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'id_building_una', 'id_building_una');
    }
}

