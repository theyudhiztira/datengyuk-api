<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationEmail extends Model
{
    protected $table = 'user_verification_email';
    protected $fillable = [
        'user_id',
        'email',
        'token',
        'description',
        'expired_at',
        'confirmed_status'
    ];
}
