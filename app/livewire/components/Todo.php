<?php

namespace App\Livewire\Components;

use App\Livewire;
use Illuminate\Support\Facades\File;

class Todo extends Livewire
{
    public $todo = "";
    public $todos;

    public function addTodo()
    {
        $this->todos->push($this->todo);

        $this->todo = "";
    }

    public function mount()
    {
        $this->todos = collect([
            'one',
            'two',
            'three'
        ]);
    }

    public function updatedTodo()
    {
        $this->todo = strtoupper($this->todo);
    }


    public function render()
    {
        return view('livewire.components.Todo');
    }
}
