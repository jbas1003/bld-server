<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    protected $table = 'tbloccupations';
    protected $fillable = [
        'occupation_name',
        'specialty',
        'company',
        'address_id',
        'created_by',
        'created_on',
    ];

    protected $timestamps = false;
}
