<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouthEncounter extends Model
{
    use HasFactory;

    protected $table = 'tblyouth_encounter';
    protected $primaryKey = 'yeId';
    protected $fillable = [
        'member_id',
        'room',
        'tribe',
        'nation',
        'event_id',
        'status',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
