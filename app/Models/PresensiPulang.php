<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PresensiPulang extends Model
{
    use HasFactory;
    protected $fillable = ['id_user','nama','jabatan','face', 'tanggal', 'jam', 'latitude', 'longitude', 'keterangan'];

    public static function boot() {
        parent::boot();
        static::creating(function (PresensiPulang $presensi) {
            $presensi->uuid = Str::uuid()->toString();
        });
    }

    public function User(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
