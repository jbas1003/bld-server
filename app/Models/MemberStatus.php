<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberStatus extends Model
{
    use HasFactory;

    protected $table = 'tblmember_statuses';
    protected $fillable = [
        'status',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
