<?php

namespace App\Models;

use App\Models\EmergencyContact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SinglesEncounter extends Model
{
    use HasFactory;

    protected $table = 'tblsingles_encounter';
    protected $primaryKey = 'seId';
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
