<?php

namespace App\Helpers;

class OpenLocationCode
{
    private static $codeLength = 10; // Panjang kode OLC
    private static $base32 = '23456789CFGHJMPQRVWXyz'; // Karakter yang digunakan dalam OLC

    public static function encode($latitude, $longitude)
    {
        // Validasi latitude dan longitude
        if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
            throw new \InvalidArgumentException('Invalid latitude or longitude');
        }

        // Konversi latitude dan longitude ke dalam Plus Code
        return self::convertToPlusCode($latitude, $longitude);
    }

    private static function convertToPlusCode($latitude, $longitude)
    {
        // Menghitung kode untuk latitude dan longitude
        $latCode = self::encodeLatitude($latitude);
        $lngCode = self::encodeLongitude($longitude);

        return $latCode . '+' . $lngCode;
    }

    private static function encodeLatitude($lat)
    {
        // Normalisasi latitude ke rentang 0-1
        $lat = ($lat + 90) / 180;
        return self::encodeCoordinate($lat, 5);
    }

    private static function encodeLongitude($lng)
    {
        // Normalisasi longitude ke rentang 0-1
        $lng = ($lng + 180) / 360;
        return self::encodeCoordinate($lng, 5);
    }

    private static function encodeCoordinate($value, $length)
    {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $value *= 32;
            $codePoint = floor($value);
            $value -= $codePoint;

            // Pastikan codePoint dalam rentang yang valid
            if ($codePoint < 0 || $codePoint >= strlen(self::$base32)) {
                throw new \OutOfBoundsException("Code point out of bounds: $codePoint");
            }

            $code .= self::$base32[$codePoint];
        }

        return $code;
    }
}
