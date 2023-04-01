<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNumbers extends Model
{
    use HasFactory;

    protected $table = 'tblcontact_numbers';
    protected $fillable = [
        'mobile',
        'created_by',
        'created_on'
    ];

    protected $timestamps = false;
}
