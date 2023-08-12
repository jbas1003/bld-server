<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarriageEncounter extends Model
{
    use HasFactory;

    protected $table = 'tblmarriage_encounter';
    protected $primaryKey = 'meId';
    protected $fillable = [
        'member_id',
        'room',
        'event_id',
        'status',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
