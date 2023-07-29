<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarriageEncounter extends Model
{
    use HasFactory;

    protected $table = 'tblemarriage_encounter';
    protected $primary = 'meId';
    protected $fillable = [
        'member_id',
        'room',
        'spouse',
        'event_id',
        'status',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
