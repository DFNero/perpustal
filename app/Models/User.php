<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ban_until',
        'banned_reason',
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
            'ban_until' => 'datetime',
        ];
    }

    public function isBanned(): bool
    {
        return $this->ban_until && now()->isBefore($this->ban_until);
    }

    public function banUser(string $duration, string $reason = null): void
    {
        if ($duration === 'permanent') {
            $this->update([
                'ban_until' => null,
                'banned_reason' => $reason ?? 'Banned permanently',
            ]);
        } else {
            $days = (int) $duration;
            $this->update([
                'ban_until' => now()->addDays($days),
                'banned_reason' => $reason,
            ]);
        }
    }

    public function unbanUser(): void
    {
        $this->update([
            'ban_until' => null,
            'banned_reason' => null,
        ]);
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

}
