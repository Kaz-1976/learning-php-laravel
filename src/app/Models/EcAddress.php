<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcAddress extends Model
{
    protected $table = 'ec_addresses';

    protected $fillable = [
        'user_id',
        'name',
        'zip',
        'pref',
        'address1',
        'address2',
        'created_by',
        'updated_by',
    ];

    public function ec_users()
    {
        return $this->belongsTo(EcUser::class, 'user_id', 'id');
    }

    public function ec_prefs()
    {
        return $this->belongsTo(EcPref::class, 'pref', 'code');
    }

    public function ec_carts()
    {
        return $this->hasMany(EcCart::class, 'address_id', 'id');
    }
}
