<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'cms_kabupatens';
    protected $hidden = ['kd_prov', 'kd_kab'];

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class, 'id_cms_kabupatens', 'id');
    }

    public function provinsi()
    {
        return $this->hasOne(Provinsi::class, 'id', 'id_cms_provinsis');
    }
}
