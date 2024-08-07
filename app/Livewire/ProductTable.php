<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class ProductTable extends Component
{
    use WithFileUploads, WithPagination;

    public $search = '';
    public $id;
    public $modalEdit = false;
    public $modalEditFoto = false;
    public $modalCreate = false;


    #[Validate('string|required|min:3')]
    public $name = '';
    #[Validate('required')]
    public $category_id = '';
    #[Validate('numeric|required|min:3')]
    public $price = 0;
    #[Validate('string|required|min:3')]
    public $description = '';
    // #[Validate('required|image|max:2048|mimes:png,jpg,jpeg')]
    public $image;

    // public $image_edit;

    public function store()
    {
        $this->validate();
        $product_edit = Product::find($this->id);
        $product = $product_edit ?? new Product();
        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->price = $this->price;
        $product->description = $this->description;
        $this->image->store('public/images');
        $product->image = $this->image->hashName();
        $product->save();

        session()->flash('status', 'Product created successfully');
        $this->reset();
    }

    public function setEdit(Product $product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->description = $product->description;
        // $this->image = $product->image;
        $this->modalEdit = true;
    }

    public function setEditFoto(Product $product)
    {
        $this->id = $product->id;
        $this->image = $product->image;
        $this->modalEditFoto = true;
    }

    public function setCreate()
    {
        $this->reset();
        $this->modalCreate = true;
    }

    public function update(Product $product)
    {

        $this->validate();

        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->price = $this->price;
        $product->description = $this->description;
        $product->save();

        $this->reset();
    }

    public function updateFoto(Product $product)
    {
        // $this->validate();

        if ($this->image != null && $product->image) {
            Storage::delete('public/images/' . $product->image);
        }

        $this->image->store('public/images');
        $product->image = $this->image->hashName();
        $product->save();

        $this->reset();
    }

    public function clear()
    {
        $this->name = '';
        $this->id = null;
        $this->category_id = '';
        $this->price = 0;
        $this->description = '';
        $this->image = '';
    }

    public function delete(Product $product)
    {
        if ($product->image) {
            Storage::delete('public/images/' . $product->image);
        }
        $product->delete();
        session()->flash('status', 'Product deleted successfully');
    }

    public function changeStatus(Product $product)
    {
        $product->in_stock = $product->in_stock ? 0 : 1;
        $product->save();
        session()->flash('status', 'Product status changed successfully');
    }

    public function closeModal()
    {
        $this->reset();
    }


    public function render()
    {
        $categories = Category::all();
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('category', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('price', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);
        return view('livewire.product-table', compact('products', 'categories'));
    }
}
