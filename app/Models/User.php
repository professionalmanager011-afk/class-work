<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

// Implementing MustVerifyEmail enables Breeze's verification notification and
// allows routes using the verified middleware to protect authenticated pages.
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
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
     * Create and persist a short-lived hashed email verification code.
     */
    public function issueEmailVerificationCode(): string
    {
        $code = (string) random_int(100000, 999999);

        $this->forceFill([
            'email_verification_code' => Hash::make($code),
            'email_verification_code_expires_at' => now()->addMinutes(10),
        ])->save();

        return $code;
    }

    /**
     * Validate the code without ever storing the plaintext value.
     */
    public function verifyEmailCode(string $code): bool
    {
        if (
            ! $this->email_verification_code
            || ! $this->email_verification_code_expires_at
            || now()->greaterThan($this->email_verification_code_expires_at)
            || ! Hash::check($code, $this->email_verification_code)
        ) {
            return false;
        }

        $this->forceFill([
            'email_verified_at' => $this->email_verified_at ?? now(),
            'email_verification_code' => null,
            'email_verification_code_expires_at' => null,
        ])->save();

        return true;
    }
}
