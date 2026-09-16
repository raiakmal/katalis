<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "cms_users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'employee_code','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function direktorat()
    {
        return $this->hasOne(Direktorat::class, 'id', 'id_cms_departments');
    }

    public function provinsi()
    {
        return $this->hasOne(Provinsi::class, 'id', 'id_cms_provinsis');
    }

    public function kabupaten()
    {
        return $this->hasOne(Kabupaten::class, 'id', 'id_cms_kabupatens');
    }

    public function kecamatan()
    {
        return $this->hasOne(Kecamatan::class, 'id', 'id_cms_kecamatans');
    }

    public function desa()
    {
        return $this->hasOne(Desa::class, 'id', 'id_cms_desas');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'id_cms_users', 'id');
    }

    public function privilege()
    {
        return $this->hasOne(Privilege::class, 'id', 'id_cms_privileges');
    }

    public function totalReports()
    {
        return $this->hasMany(Report::class, 'id_cms_users', 'id')
        ->where('status', 'Telah Diverifikasi')
        ->where('report_type', 'Tanam')
        ->whereYear('plant_at', \Carbon\carbon::now()->format('Y'))
        ->orderBy('created_at', 'DESC');
    }

    public function lastReport()
    {
        return $this->hasOne(Report::class, 'id_cms_users', 'id')
        ->where('status', 'Telah Diverifikasi')
        ->where('report_type', 'Tanam')
        ->whereYear('plant_at', \Carbon\carbon::now()->format('Y'))
        ->orderBy('created_at', 'DESC');
    }

    // public static function getReports($id)
    // {
    //     $instance = (new User)->find($id);
        
    //     if ($instance->privilege->is_superadmin) {
    //         $instance->reports = self::reports();
    //     } else {
    //         $instance->reports = self::reports(true);
    //     }
    //     return $instance;
    // }
}
