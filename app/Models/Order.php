<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order',
        'no_table',
        'name',
        'total_price',
        'date',
        'status',
        'payment_status',
        'note',
        'snap_token'
    ];

    public function orderList()
    {
        return $this->hasMany(OrderList::class);
    }
}
