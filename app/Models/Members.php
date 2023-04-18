<?php

namespace App\Models;

use App\Models\ContactInfo;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Member As Authenticatable;

class Members extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'tblmembers';
    protected $primaryKey = 'member_id';
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

    public function contactInfo ():BelongsTo {
        return $this->belongsTo(ContactInfo::class);
    }
}
