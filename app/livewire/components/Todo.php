<?php

namespace App\Livewire\Components;

use App\Livewire;

class Todo extends Livewire
{

    public $todos = [
        'one',
        'two',
        'three'
    ];

    public function addTodo()
    {
        $this->todos[] = 'new todo';
    }
}
