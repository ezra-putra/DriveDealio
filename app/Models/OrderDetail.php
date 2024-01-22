<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = "orderdetails";
    protected $primaryKey = null;
    protected $fillable = [
        'orders_id',
        'spareparts_id',
        'quantityordered',
        'unitprice',
        'discount',
    ];
}
