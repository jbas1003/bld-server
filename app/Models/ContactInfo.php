<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'tblcontact_infos';
    protected $fillable = [
        'member_id',
        'address_id',
        'contactNumber_id',
        'email_id',
        'occupation_id',
        'created_by',
        'created_on'
    ];

    public $timestamps = false;

    public function members(): HasMany {
        return $this->hasMany(Members::class);
    }

    public function addresses(): HasMany {
        return $this->hasMany(Addresses::class);
    }

    public function contactNumbers(): HasMany {
        return $this->hasMany(ContactNumbers::class);
    }

    public function emails(): HasMany {
        return $this->hasMany(Emails::class);
    }

    public function occupations(): HasOne {
        return $this->hasOne(Occupation::class);
    }
}
