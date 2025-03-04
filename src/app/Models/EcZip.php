<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class EcZip extends Model
{

    use Compoships;

    protected $table = 'ec_zips';

    protected $fillable = [
        'code',
        'pref_code',
        'city_code',
        'created_by',
        'updated_by'
    ];

    public function ec_prefs()
    {
        return $this->belongsTo(EcPref::class, 'pref_code', 'code');
    }

    public function ec_cities()
    {
        return $this->belongsTo(EcCity::class, ['pref_code', 'city_code'], ['pref_code', 'code']);
    }

    public function ec_addresses()
    {
        return $this->hasMany(EcAddress::class, 'zip', 'code');
    }
}
