<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderList;
use App\Models\Table;

class OrderTable extends Component
{
    public $search = '';
    public $status = '';
    public $date;
    public $id;
    public $modalStatus = false;
    public $modalCreate = false;

    public $totalPrice = 0;
    public $items = [];
    public $noOrder = '';
    public $orderBy = '';
    public $noTable = '';
    public $note = '';
    public $product_id = '';

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function addProduct()
    {
        $product = Product::find($this->product_id);
        // Check if product already exists in the cart
        $key = array_search($product->id, array_column($this->items, 'id'));

        if ($key !== false) {
            // Product found, increment quantity
            $this->items[$key]['quantity']++;
        } else {
            // Product not found, add to cart
            $this->items[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->calculateTotalPrice();
    }

    public function updateQuantity($index, $quantity)
    {
        $this->items[$index]['quantity'] = $quantity;
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        foreach ($this->items as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
    }

    public function delete($id)
    {
        // Find the product index in the cart
        $key = array_search($id, array_column($this->items, 'id'));

        if ($key !== false) {
            // Remove the product from the cart
            unset($this->items[$key]);
            $this->items = array_values($this->items); // Reindex array
            // $this->chart_count = count($this->chart);
        }
        $this->calculateTotalPrice();
    }

    public function openModalStatus($id)
    {
        $this->id = $id;
        $this->status = Order::find($id)->status;
        $this->modalStatus = true;
    }

    public function openModalCreate()
    {
        $this->modalCreate = true;
    }

    public function closeModal()
    {
        $this->status = '';
        $this->id = '';
        $this->modalStatus = false;
        $this->modalCreate = false;
        $this->reset();
        $this->mount();
    }

    public function check(Order $order)
    {
        return redirect()->route('order.detail', $order);
    }

    public function updateStatus()
    {
        $order = Order::find($this->id);
        $order->status = $this->status;
        $order->save();

        // Update the component's status for immediate UI reflection
        $this->closeModal();
    }

    public function storeOrder()
    {
        $ordersCount = Order::count();
        $this->noOrder = 'OR' . date('Ymd') . mt_rand(1000, 9999) . $ordersCount;
        $table = Table::find($this->noTable);
        $order = Order::create([
            'no_order' => $this->noOrder,
            'table_id' => $table->id,
            'name' => $this->orderBy,
            'total_price' => $this->totalPrice,
            'date' => date('Y-m-d'),
            'status' => 'Pending',
            'payment_status' => 'Unpaid',
            'note' => $this->note
        ]);

        foreach ($this->items as $item) {
            OrderList::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        $this->closeModal();
    }

    public function changeDate()
    {
        $this->date = $this->date;
    }

    public function render()
    {
        $products = Product::where('in_stock', true)->get();
        $tables = Table::all();
        $orders = Order::query()
            ->when($this->search, function ($query) {
                $query->where('no_order', 'like', '%' . $this->search . '%')
                    ->orWhere('no_table', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->where('date', $this->date)
            ->latest()
            ->paginate(10);
        return view('livewire.order-table', compact('orders', 'products', 'tables'));
    }
}
