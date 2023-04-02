<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;

    protected $table = 'tbladdresses';
    protected $fillable = [
        'address_line1',
        'address_line2',
        'city',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
