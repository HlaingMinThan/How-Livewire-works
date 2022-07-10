<?php

namespace App\Livewire\Components;

use App\Livewire;

class Todo extends Livewire
{
    public $todo = "";
    public $todos = [
        'one',
        'two',
        'three'
    ];

    public function addTodo()
    {
        $this->todos[] = $this->todo;

        $this->todo = "";
    }
}
