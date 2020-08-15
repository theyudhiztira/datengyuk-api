<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDataLogs extends Model
{
    protected $table = 'user_data_logs';
    protected $fillable = [
        'user_id',
        'field',
        'old_value',
        'new_value'
    ];
}
