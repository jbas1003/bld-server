<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

    protected $table = 'tblchildren';
    protected $primaryKey = 'child_id';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
