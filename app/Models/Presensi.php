<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = ['id_user','nama','jabatan','face', 'tanggal', 'jam', 'latitude', 'longitude', 'keterangan'];

    public static function boot() {
        parent::boot();
        static::creating(function (Presensi $presensi) {
            $presensi->uuid = Str::uuid()->toString();
        });
    }

    // Dalam model Presensi
    public function presensiPulang()
    {
        return $this->hasMany(PresensiPulang::class, 'nama', 'nama')
                    ->whereColumn('tanggal', 'tanggal')
                    ->whereColumn('jabatan', 'jabatan');
    }


    public function User(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
