<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_CLIENT = 'client';
    const ROLE_ADMIN = 'admin';
    const ROLE_TRUCKER = 'trucker';
    const ALLOWED_ROLES = [
        self::ROLE_CLIENT,
        self::ROLE_ADMIN,
        self::ROLE_TRUCKER,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    public function setRoleAttribue(string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES)) {
            throw new \Exception('Invalid role');
        }
        $this->attributes['role'] = $role;
    }
}
