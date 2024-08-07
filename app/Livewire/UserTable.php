<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class UserTable extends Component
{
    use WithPagination;
    public $search = '';

    public function delete(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $user->delete();
            });
            session()->flash('status', 'User deleted successfully');
        } catch (\Throwable $th) {
            session()->flash('status', 'User not deleted successfully');
        }
    }
    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()->paginate(5);
        return view('livewire.user-table', compact('users'));
    }
}
