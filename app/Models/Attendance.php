<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'tblattendances';
    protected $fillable = [
        'event_id',
        'event_date',
        'created_by',
        'updated_by',
    ];

    public $timestamps = false;
}
