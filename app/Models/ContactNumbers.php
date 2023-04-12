<?php

namespace App\Models;

use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactNumbers extends Model
{
    use HasFactory;

    protected $table = 'tblcontact_numbers';
    protected $fillable = [
        'mobile',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;

    public function contactInfo ():BelongsTo {
        return $this->belongsTo(ContactInfo::class);
    }
}
