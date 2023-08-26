<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationships extends Model
{
    use HasFactory;

    protected $table = 'tblrelationships';
    protected $primaryKey = 'relationship_id';
    protected $fillable = [
        'relationship',
        'create_by'
    ];

    public $timestamps = false;
}
