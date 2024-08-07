<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index(Order $order)
    {
        return view('order-detail', compact('order'));
    }

    public function success(Order $order)
    {
        $order->payment_status = 'Paid';
        $order->save();
        return redirect()->route('order.detail', $order);
    }
}
