<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmercencyContactinfo extends Model
{
    use HasFactory;

    protected $table = 'tblemercency_contactinfos';
    protected $fillable = [
        'member_id',
        'contactNumber_id',
        'created_by',
        'created_on'
    ];

    protected $timestamps = false;
}
