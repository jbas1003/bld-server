<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAccounts extends Model
{
    use HasFactory;

    protected $table = 'tblmember_accounts';
    protected $primaryKey = 'memberAccount_id';
    protected $fillable = [
        'member_id',
        'username',
        'password',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;
}
