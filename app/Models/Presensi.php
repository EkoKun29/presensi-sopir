<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = ['id_user','nama','jabatan','face', 'tanggal', 'jam', 'latitude', 'longitude'];

    public static function boot() {
        parent::boot();
        static::creating(function (Presensi $presensi) {
            $presensi->uuid = Str::uuid()->toString();
        });
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
