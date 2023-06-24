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
        'encounter_id',
        'yeId',
        'seId',
        'meId',
        'speId',
        'feId',
        'ylssId',
        'lssId',
        'relationship',
        'created_by'
    ];

    public $timestamps = false;
}
