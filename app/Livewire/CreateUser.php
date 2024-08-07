<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateUser extends Component
{
    #[Validate('string|required|max:255')]
    public $name;

    #[Validate('email|required|max:255|unique:users')]
    public $email;

    #[Validate('string|required')]
    public $password;

    #[Validate('string|required|same:password')]
    public $password2;

    #[Validate('required')]
    public $role;

    public function store()
    {
        $this->validate();

        $user =  User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user->assignRole($this->role);

        session()->flash('success', 'User created successfully!');
        return redirect()->route('users');
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
