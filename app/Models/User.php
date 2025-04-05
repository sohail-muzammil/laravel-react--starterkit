<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
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

    /**
     * Get the social accounts that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<UserSocial>
     */
    public function userSocialAccounts()
    {
        return $this->hasMany(UserSocial::class);
    }


    /**
     * Suspend the user for a specific period or indefinitely
     * 
     * @param Carbon|null $until Optional suspension end date (null for indefinite)
     */
    public function suspend(Carbon $until = null)
    {
        $this->update([
            'suspended_at' => Carbon::now(),
            'suspended_until' => $until,
        ]);
    }

    /**
     * Unsuspend the user (clear both suspension timestamps)
     */
    public function unsuspend()
    {
        $this->update([
            'suspended_at' => null,
            'suspended_until' => null,
        ]);
    }

    /**
     * Check if user is currently suspended
     */
    public function isSuspended(): bool
    {
        // Indefinite suspension
        if ($this->suspended_at && is_null($this->suspended_until)) {
            return true;
        }

        // Temporary suspension check
        if ($this->suspended_until) {
            return Carbon::now()->lt($this->suspended_until);
        }

        return false;
    }

    /**
     * Get the remaining suspension duration in human format
     */
    public function suspensionRemaining(): ?string
    {
        if (!$this->isSuspended()) {
            return null;
        }

        if ($this->suspended_until) {
            return Carbon::now()->diffForHumans($this->suspended_until, true);
        }

        return 'indefinite';
    }
}
