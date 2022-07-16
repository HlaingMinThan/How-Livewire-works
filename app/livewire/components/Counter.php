<?php

namespace App\Livewire\Components;

class Counter
{
    public $count = 8;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.components.counter');
    }
}
