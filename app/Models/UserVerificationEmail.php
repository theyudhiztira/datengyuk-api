<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationEmail extends Model
{
    protected $table = 'email_verification_token';
    protected $fillable = [
        'user_id',
        'email',
        'token',
        'expired_at',
        'confirmed',
        'confirmed_at'
    ];
}
