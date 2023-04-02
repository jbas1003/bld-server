<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'tblcontact_infos';
    protected $fillable = [
        'member_id',
        'address_id',
        'contactNumber_id',
        'email_id',
        'occupation_id',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
