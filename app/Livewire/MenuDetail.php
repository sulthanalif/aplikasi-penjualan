<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class MenuDetail extends Component
{
    public $id;
    public function mout($id)
    {
        $this->id = $id;
    }

    public function back()
    {
        return redirect()->route('welcome');
    }
    public function render()
    {
        $order = Order::find($this->id);
        return view('livewire.menu-detail', compact('order'));
    }
}
