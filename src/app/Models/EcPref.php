<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcPref extends Model
{
    protected $table = 'ec_prefs';

    protected $fillable = [
        'code',
        'name',
        'created_by',
        'updated_by'
    ];

    public function ec_cities()
    {
        return $this->hasMany(EcCity::class, 'pref_code', 'code');
    }

    public function ec_zips()
    {
        return $this->hasMany(EcZip::class, 'pref_code', 'code');
    }

    public function ec_addresses()
    {
        return $this->hasMany(EcAddress::class, 'pref', 'code');
    }
}
