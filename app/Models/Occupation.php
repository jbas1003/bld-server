<?php

namespace App\Models;

use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Occupation extends Model
{
    use HasFactory;

    protected $table = 'tbloccupations';
    protected $fillable = [
        'occupation_name',
        'specialty',
        'company',
        'address_line1',
        'address_line2',
        'city',
        'created_by',
        'created_on',
    ];

    public $timestamps = false;

    public function contactInfo ():BelongsTo {
        return $this->belongsTo(ContactInfo::class);
    }
}
