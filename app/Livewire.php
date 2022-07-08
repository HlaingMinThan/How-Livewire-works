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
        return Blade::render(
            $class->render(),
            $this->getProperties($component)
        );
    }
}
