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
        'ba_no',              // Personal Number
        'rank',               // Major, Captain, etc.
        'corps',              // Infantry, Signals, etc.
        'unit',               // Current Unit
        'formation',          // e.g., 9 Div
        'appointment',        // e.g., GSO-2
        'contact_no',
        'blood_group',
        'date_of_commission',
        'google2fa_secret',   // For 2FA Security
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


    public function isAdmin()
{
    return $this->role === 'admin';
}



}
