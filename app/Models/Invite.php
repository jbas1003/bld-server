<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $table = 'tblinvites';
    protected $primaryKey = 'invite_id';
    protected $fillable = [
        'event_encounter_id',
        'inviter_id',
        'relationship',
        'created_by'
    ];

    public $timestamps = false;
}
