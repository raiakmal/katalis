<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'cms_provinsis';
    
    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class, 'id_cms_provinsis', 'id');
    }
}
