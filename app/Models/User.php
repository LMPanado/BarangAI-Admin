<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens; // Added for Flutter API Authentication

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable; // Added HasApiTokens here

    /**
     * Role Constants
     * 0: Resident, 1: System Admin, 2: Captain, 3: Official
     */
    const ROLE_RESIDENT = 0;
    const ROLE_ADMIN = 1;
    const ROLE_CAPTAIN = 2;
    const ROLE_OFFICIAL = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',     // Used for granular access (0, 1, 2, 3)
        'is_admin', // Existing boolean for general admin/client split
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'role' => 'integer', // Ensure role is treated as an integer
        ];
    }

    /**
     * Role Helper Methods
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCaptain(): bool
    {
        return $this->role === self::ROLE_CAPTAIN;
    }

    public function isOfficial(): bool
    {
        return $this->role === self::ROLE_OFFICIAL;
    }

    public function isResident(): bool 
    {
        return $this->role === self::ROLE_RESIDENT;
    }

    /**
     * Checks if the user belongs to any administrative role (1, 2, or 3)
     */
    public function isStaff(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_CAPTAIN, self::ROLE_OFFICIAL]);
    }

    /**
     * Get the resident profile associated with the user.
     * * This is the "Inverse" of the relationship in Resident.php
     */
    public function resident(): HasOne
    {
        return $this->hasOne(Resident::class);
    }
}