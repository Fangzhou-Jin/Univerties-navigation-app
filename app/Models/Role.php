<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'roles_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_role_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'role_name_una',
    ];

    /**
     * Get the users for the role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_role_una', 'id_role_una');
    }
}

