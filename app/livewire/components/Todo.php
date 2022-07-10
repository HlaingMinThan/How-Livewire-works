<?php

namespace App\Livewire\Components;

use App\Livewire;

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
}
