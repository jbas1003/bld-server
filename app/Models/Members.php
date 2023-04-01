<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
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
        'religion',
        'baptism',
        'confirmation',
        'occupation',
        'specialty',
        'company',
        'company_address',
    ];

    public $timestamps = false;
}
