<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class EcCity extends Model
{
    use Compoships;

    protected $table = 'ec_cities';

    protected $fillable = [
        'pref_code',
        'name',
        'created_by',
        'updated_by'
    ];

    public function ec_prefs()
    {
        return $this->belongsTo(EcPref::class, 'pref_code', 'code');
    }

    public function ec_zips()
    {
        return $this->hasMany(EcZip::class, ['pref_code', 'city_code'], ['pref_code', 'code']);
    }

    public function ec_addresses()
    {
        return $this->hasMany(EcAddress::class, ['pref_code', 'city_code'], ['pref_code', 'code']);
    }
}
