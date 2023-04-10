<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $table = 'tblevent_types';
    protected $primaryKey = 'event_type_id';
    protected $fillable = [
        'event_type_name',
        'event_type_category',
        'created_by',
        'created_on',
    ];

    public $timestamps = false;
}