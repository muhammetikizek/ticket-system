<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'last_used_store_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Scope a query to only include admins.
     *
     * @param [type] $query
     * @return void
     */
    public function scopeIsAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Check if user is admin.
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->is_admin ?? false;
    }

    /**
     * Check if user is enabled.
     *
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->enabled ?? false;
    }


    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_users', 'user_id', 'store_id');
    }

    public function lastUsedStore()
    {
        return $this->belongsTo(Store::class, 'last_used_store_id');
    }
}
