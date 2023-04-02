<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContacts extends Model
{
    use HasFactory;

    protected $table = 'tblemergency_contacts';
    protected $fillable = [
        'emergencyContact_member_id',
        'contactNumber_id',
        'member_id',
        'created_by',
        'created_on'
    ];

    protected $timestamps = false;
}
