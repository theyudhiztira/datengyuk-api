<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyData extends Model
{
    protected $table = 'company_data';
    protected $primaryKey = 'company_id';
    protected $fillable = [
        'user_id',
        'company_name',
        'employee_number',
        'company_website',
        'company_address'
    ];
}
