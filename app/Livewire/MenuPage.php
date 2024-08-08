<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Table;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\OrderList;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;

class MenuPage extends Component
{
    use WithPagination;

    public $noTable = '';

    public $no_order = '';


    public $search = '';
    public $noOrder = '';
    public $orderBy = '';
    public $note = '';
    public $chart = [];
    public $chart_count = 0;
    public $totalPrice = 0;

    public $modalChart = false;
    public $messageOrder = false;
    public $modalCheckOrder = false;
    public $messageCheck = false;
    public $modalShow = false;
    public $modalInformation = false;
    public $productShow = [];

    public function mount()
    {
        $code = request()->query('code');
        $table = Table::where('code', $code)->first();
        if ($table) {
            $this->noTable = $table->number;
        } else {
            $this->openModalInformation();
        }
    }

    public function openModalInformation()
    {
        $this->modalInformation = true;
    }

    public function openModalShow($id)
    {
        $product = Product::find($id);
        $this->modalShow = true;
        $this->productShow = $product;
    }

    public function openModalCheckOrder()
    {
        $this->modalCheckOrder = true;
    }

    public function checkOrder()
    {
        $order = Order::where('no_order', $this->no_order)->first();
        if ($order) {
            return redirect()->route('order.detail.guest', $order);
        } else {
            $this->messageCheck = true;
        }
    }

    public function addToCart(Product $product)
    {
        // Check if product already exists in the cart
        $key = array_search($product->id, array_column($this->chart, 'id'));

        if ($key !== false) {
            // Product found, increment quantity
            $this->chart[$key]['quantity']++;
        } else {
            // Product not found, add to cart
            $this->chart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->chart_count = count($this->chart);
        $this->calculateTotalPrice();
    }

    public function storeOrder()
    {
        $ordersCount = Order::count();
        $this->noOrder = 'OR' . date('Ymd') . mt_rand(1000, 9999) . $ordersCount;
        $table = Table::where('number', $this->noTable)->first();
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

        foreach ($this->chart as $item) {
            OrderList::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        $this->openMessage();
    }

    public function filter(Category $category)
    {
        $this->search = $category->name;
    }

    public function resetFilter()
    {
        $this->search = '';
    }

    public function goToCharts()
    {
        // dd($this->chart);
        $this->modalChart = true;
    }

    public function openMessage()
    {
        $this->messageOrder = true;
    }

    public function closeModal()
    {
        $this->modalChart = false;
        $this->modalCheckOrder = false;
        $this->messageCheck = false;
        $this->modalShow = false;
        $this->modalInformation = false;
        $this->reset(['productShow']);
    }

    public function delete($id)
    {
        // Find the product index in the cart
        $key = array_search($id, array_column($this->chart, 'id'));

        if ($key !== false) {
            // Remove the product from the cart
            unset($this->chart[$key]);
            $this->chart = array_values($this->chart); // Reindex array
            $this->chart_count = count($this->chart);
        }
        $this->calculateTotalPrice();
    }

    public function updateQuantity($index, $quantity)
    {
        $this->chart[$index]['quantity'] = $quantity;
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        foreach ($this->chart as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
    }
    public function render()
    {
        $categories = Category::all();
        $products = Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('category', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.menu-page', compact('products', 'categories'));
    }
}
