<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'cms_kecamatans';
    protected $hidden = ['kd_prov', 'kd_kab', 'kd_kec'];

    public function desas()
    {
        return $this->hasMany(Desa::class, 'id_cms_kecamatans', 'id');
    }

    public function kabupaten()
    {
        return $this->hasOne(Kabupaten::class, 'id', 'id_cms_kabupatens');
    }
}
