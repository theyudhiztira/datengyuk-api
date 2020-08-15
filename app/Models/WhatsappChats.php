<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappChats extends Model
{
    protected $table = 'whatsapp_chat';
    protected $fillable = [
        'user_id',
        'field',
        'old_value',
        'new_value'
    ];
}
