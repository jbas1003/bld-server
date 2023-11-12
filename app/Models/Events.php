<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'tblevents';
    protected $primaryKey = 'event_id';
    protected $fillable = [
        'event_name',
        'event_subtitle',
        'event_details',
        'location',
        'start_date',
        'end_date',
        'status',
        'event_type_id',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
