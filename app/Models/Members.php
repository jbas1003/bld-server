<?php

namespace App\Models;

use App\Models\Members;
use App\Models\ContactInfo;
use App\Models\EmergencyContact;
use App\Models\SinglesEncounter;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Member As Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Members extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'tblmembers';
    protected $primaryKey = 'member_id';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'nickname',
        'birthday',
        'gender',
        'civil_status',
        'spouse_member_id',
        'religion',
        'baptism',
        'confirmation',
        'member_status_id',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
    
    public function emergency_contacts(): HasManyThrough
    {
        return $this->hasManyThrough(EmergencyContact::class, SinglesEncounter::class, 'member_id', 'seId');
    }

    public function inviters(): HasManyThrough
    {
        return $this->hasManyThrough(Invite::class, SinglesEncounter::class, 'member_id', 'seId');
    }
}
