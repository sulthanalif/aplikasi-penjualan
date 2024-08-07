<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination;

    public $search = '';
    public $id = null;

    #[Validate('string|required|min:3')]
    public $name = '';

    public function store()
    {
        $this->validate();

        $category = Category::find($this->id) ?? new Category();
        $category->name = $this->name;
        $category->save();

        session()->flash('status', 'Category created successfully');
        $this->name = '';
    }

    public function setEdit(Category $category)
    {
        $this->id = $category->id;
        $this->name = $category->name;
    }

    public function clear()
    {
        $this->name = '';
    }

    public function delete(Category $category)
    {
        $category->delete();
        session()->flash('status', 'Category deleted successfully');
    }


    public function render()
    {
        $categories = Category::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);
        return view('livewire.category-table', compact('categories'));
    }
}
