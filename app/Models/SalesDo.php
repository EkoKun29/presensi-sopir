<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDo extends Model
{
    use HasFactory;

    public function detail_do()
    {
        return $this->hasMany('App\Models\DetailSalesDo', 'id_sales_do');
    }
}
