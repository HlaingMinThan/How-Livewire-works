<?php

namespace App\Livewire\Components;

use App\Livewire;

class Counter extends Livewire
{
    public $count = 8;
    public $fee = 'price';

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.components.counter');
    }
}
