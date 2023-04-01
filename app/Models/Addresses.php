<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;

    protected $table = 'tbladdresses';
    protected $fillable = [
        'house_no',
        'street',
        'barangay',
        'subdivision',
        'city',
        'created_by',
        'created_on'
    ];

    protected $timestamps = false;
}
