<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = ['face', 'tanggal', 'jam', 'lokasi', 'uuid'];

    public static function boot() {
        parent::boot();
        static::creating(function (Presensi $item) {
            $item->uuid = Str::uuid()->toString();
        });
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
