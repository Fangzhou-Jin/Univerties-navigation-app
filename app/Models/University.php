<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'universities_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_university_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'university_name_una',
        'city_country',
        'population',
        'post_code',
    ];

    /**
     * Get the buildings for the university.
     */
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class, 'id_university_una', 'id_university_una');
    }

    /**
     * Get the departments for the university.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'id_university_una', 'id_university_una');
    }

    /**
     * Get the rooms for the university.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'id_university_una', 'id_university_una');
    }
}

