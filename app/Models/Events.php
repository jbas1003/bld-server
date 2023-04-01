<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'tblevents';
    protected $fillable = [
        'event_name',
        'event_type_id',
        'created_by',
        'updated_by',
    ];

    protected $timestamps = false;
}
