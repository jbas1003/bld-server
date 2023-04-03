<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\Member As Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Members extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'tblmembers';
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
}
