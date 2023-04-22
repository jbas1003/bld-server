<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'tblemergency_contacts';
    protected $primaryKey = 'emergencyContact_id';
    protected $fillable = [
        'seId',
        'first_name',
        'middle_name',
        'last_name',
        'relationship',
        'mobile',
        'email',
        'created_by'
    ];

    public $timestamps = false;
}
