<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'cms_desas';
    
    public function kecamatan()
    {
        return $this->hasOne(Kecamatan::class, 'id', 'id_cms_kecamatans');
    }
}
