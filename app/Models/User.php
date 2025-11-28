<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'users_una';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_user_una';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username_una',
        'email_una',
        'password_una',
        'google_auth_una',
        'id_role_una',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password_una',
        'google_auth_una',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role_una', 'id_role_una');
    }
}

