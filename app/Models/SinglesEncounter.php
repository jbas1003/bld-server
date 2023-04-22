<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinglesEncounter extends Model
{
    use HasFactory;

    protected $table = 'tblsingles_encounter';
    protected $primaryKey = 'seId';
    protected $fillable = [
        'member_id',
        'emergencyContact_id',
        'room',
        'tribe',
        'nation',
        'created_by'
    ];

    public $timestamps = false;
}
