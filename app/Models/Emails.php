<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $table = 'tblemails';
    protected $fillable = [
        'email',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
