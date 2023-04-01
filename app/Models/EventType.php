<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $table = 'tblevent_types';
    protected $fillable = [
        'event_type_name',
        'created_by',
        'updated_by',
    ];

    protected $timestamps = false;
}