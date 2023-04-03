<?php

namespace App\Models;

use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emails extends Model
{
    use HasFactory;

    protected $table = 'tblemails';
    protected $fillable = [
        'email',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;

    public function contactInfo ():BelongsTo {
        return $this->belongsTo(ContactInfo::class);
    }
}
