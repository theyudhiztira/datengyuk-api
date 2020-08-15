<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'email',
        'token',
        'expired_at',
        'status'
    ];
}
