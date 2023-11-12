<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRelationships extends Model
{
    use HasFactory;

    protected $table = 'tblmember_relationships';
    protected $primaryKey = 'member_relationship_id';
    protected $fillable = [
        'member_id',
        'relative_id',
        'relationship_id',
        'created_by'
    ];

    public $timestamps = false;
}
