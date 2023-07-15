<?php

namespace App\Models;

use App\Models\EmergencyContact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
