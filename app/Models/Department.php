<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'departments_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_department_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'department_name_una',
        'id_university_una',
    ];

    /**
     * Get the university that owns the department.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'id_university_una', 'id_university_una');
    }
}

