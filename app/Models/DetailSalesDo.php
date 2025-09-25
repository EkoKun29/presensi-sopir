<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSalesDo extends Model
{
    use HasFactory;

    public function do()
    {
        return $this->belongsTo('App\Models\SalesDo', 'id_sales_do');
    }
}
