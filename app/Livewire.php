<?php

namespace App;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use ReflectionProperty;

class Livewire
{
    public function getProperties($component)
    {
        $properties = [];
        $class = new ReflectionClass($component);
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $eachProperty) {
            $properties[$eachProperty->getName()] = $eachProperty->getValue(new $component);
        }
        return $properties;
    }

    public function initialRender($component)
    {
        $class = new $component;
        $html = Blade::render(
            $class->render(),
            $this->getProperties($component)
        );
        $data = ['class' => get_class($class), 'data' => $this->getProperties($component)];
        $data = json_encode($data);
        return "
            <div wire:snapshot='$data'>
                {$html}
            </div>
        ";
    }
}
