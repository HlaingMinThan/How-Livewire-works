<?php

namespace App;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use ReflectionProperty;

class Livewire
{
    public function setProperties($component, $properties)
    {
        foreach ($properties as $key => $value) {
            $component->{$key} = $value;
        }
    }
    public function getProperties($component)
    {
        $properties = [];
        $class = new ReflectionClass($component);
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $eachProperty) {
            $properties[$eachProperty->getName()] = $eachProperty->getValue($component);
        }
        return $properties;
    }

    /**
     * from snapshot to component
     */
    public function fromSnapshot($snapshot)
    {
        $class = $snapshot['class'];
        $data = $snapshot['data'];

        $component = new $class;

        $this->setProperties($component, $data);

        return $component;
    }

    /**
     * from component to snapshot
     */
    public function toSnapshot($component)
    {
        $html = Blade::render(
            $component->render(),
            $properties = $this->getProperties($component)
        );
        $snapshot = ['class' => get_class($component), 'data' => $properties];

        return [$html, $snapshot];
    }

    public function callMethod($component, $method)
    {
        $component->{$method}();
    }

    public function propertyUpdate($component, $property, $value)
    {
        $component->{$property} = $value;
    }

    public function initialRender($namespace)
    {
        $component = new $namespace;
        [$html, $snapshot] = $this->toSnapshot($component);
        $snapshotAttr = json_encode($snapshot);
        return "
            <div wire:snapshot='$snapshotAttr'>
                {$html}
            </div>
        ";
    }

    public function render()
    {
        // $this is the object calling from component class because of extending
        $fileName = (new \ReflectionClass($this))->getShortName();
        return File::get(resource_path() . '/views/livewire/components/' . $fileName . '.blade.php');
    }
}
