<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $income = Order::where('payment_status', 'Paid')
            ->where('status', 'success')
            ->whereDate('date', date('Y-m-d'))
            ->sum('total_price');
        $order = Order::whereDate('date', date('Y-m-d'))->count();
        $orderPaid = Order::where('payment_status', 'Paid')
        ->whereDate('date', date('Y-m-d'))
            ->count();
        $orderUnpaid = Order::where('payment_status', 'Unpaid')
        ->whereDate('date', date('Y-m-d'))
            ->count();
        return view('livewire.dashboard', compact('income', 'order', 'orderPaid', 'orderUnpaid'));
    }
}
