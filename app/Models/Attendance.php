<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'tblattendances';
    protected $primaryKey = 'attendance_id';
    protected $fillable = [
        'member_id',
        'event_id',
        'status',
        'event_date',
        'created_by',
        'created_on',
    ];

    public $timestamps = false;
}
