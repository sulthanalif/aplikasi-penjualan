<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\OrderList;
use App\Models\Product;

class OrderDetail extends Component
{
    public $id;

    public $modalPayment = false;
    public $modalEdit = false;
    public $method = '';
    public $buttonPayment = true;
    public $buttonModalSnap = false;
    public $snap_token = '';

    //edit
    public $totalPrice = 0;
    public $items = [];
    public $noOrder = '';
    public $orderBy = '';
    public $noTable = '';
    public $note = '';
    public $product_id = '';

    public $paymentMethod = '';

    public function mount($id)
    {
        $this->id = $id;
        $products = OrderList::where('order_id', $id)->get();
        foreach ($products as $product) {
            $this->items[] = [
                'id' => $product->product->id,
                'name' => $product->product->name,
                'price' => $product->product->price,
                'quantity' => $product->quantity
            ];
        }
        $order = Order::find($id);

        if ($order->payment_status == 'Unpaid') {
            if ($order->snap_token != null) {
                $this->snap_token = $order->snap_token;
            }
        } else {
            $this->buttonPayment = false;
        }

        $this->calculateTotalPrice();
    }

    public function successPayment()
    {
        $order = Order::find($this->id);
        $order->payment_status = 'Paid';
        $order->save();
        $this->snap_token = '';
        $this->buttonPayment = false;
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

    public function back()
    {
        return redirect()->route('orders');
    }

    public function openModalEdit()
    {
        $this->modalEdit = true;
    }

    public function openModalPayment()
    {
        $this->modalPayment = true;
    }

    public function closeModal()
    {
        $this->reset('items', 'totalPrice');
        $this->mount($this->id);
        $this->method = '';
        $this->modalPayment = false;
        $this->modalEdit = false;
        $this->product_id = '';
    }

    public function openModalSnap()
    {
        $order = Order::find($this->id);
        $this->snap_token = $order->snap_token;

    }

    public function processPayment()
    {
        $order = Order::find($this->id);
        if ($this->method == 'tunai') {
            $order->payment_status = 'Paid';
            $order->save();
            $this->closeModal();
            $this->buttonPayment = false;
        } elseif ($this->method == 'paymentGateway') {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->no_order,
                    'gross_amount' => $order->total_price,
                ),
                'customer_details' => array(
                    'first_name' => $order->name,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $order->snap_token = $snapToken;
            $order->save();
            redirect()->route('order.detail', $this->id);
        }
    }

    public function updateOrder()
    {
        $order = Order::find($this->id);
        $order->total_price = $this->totalPrice;
        $order->save();
        $order->orderList()->delete();
        foreach ($this->items as $item) {
            OrderList::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }
        $this->closeModal();
        $this->buttonPayment = true;
        $this->product_id = '';
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

    public function render()
    {
        $products = Product::where('in_stock', true)->get();
        $order = Order::find($this->id);
        if ($order->payment_status == 'Paid') {
            $this->buttonPayment = false;
        }
        return view('livewire.order-detail', compact('order', 'products'));
    }
}
