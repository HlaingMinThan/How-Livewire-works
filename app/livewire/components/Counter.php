<?php

namespace App\Livewire\Components;

class Counter
{
    public $count = 8;
    public $fee = 'price';

    public function increment()
    {
        $this->count = $this->count + 1;
    }

    public function render()
    {
        return '<h1>{{$count}} {{$fee}}</h1> <button wire:click="increment">increment</button>';
    }
}
