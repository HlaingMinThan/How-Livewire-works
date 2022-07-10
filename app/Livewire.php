<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use ReflectionProperty;
use Illuminate\Support\Str;

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
        $meta = $snapshot['meta'];

        $component = new $class;
        $properties = $this->hydrateProperties($data, $meta);

        $this->setProperties($component, $properties);

        return $component;
    }

    /**
     *  comeback from javascript change proper format of php data
     */
    public function hydrateProperties($properties, $meta)
    {
        $data = [];

        foreach ($properties as $key => $value) {
            if (isset($meta[$key]) && $meta[$key] ===  'collection') {
                $value = collect($value);
            }
            $data[$key] = $value;
        }

        return $data;
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
        [$properties, $meta] = $this->dehydrateProperties($properties);

        $snapshot = ['class' => get_class($component), 'data' => $properties, 'meta' => $meta];

        return [$html, $snapshot];
    }

    /**
     *  to pass javascript
     */
    public function dehydrateProperties($properties)
    {
        $data = [];
        $meta = [];

        foreach ($properties as $key => $value) {
            if ($value instanceof Collection) {
                $data[$key] = $value->toArray(); // to pass javascript as a array
                $meta[$key] = 'collection';
            }
            $data[$key] = $value;
        }

        return [$data, $meta];
    }

    public function callMethod($component, $method)
    {
        $component->{$method}();
    }

    public function propertyUpdate($component, $property, $value)
    {
        $component->{$property} = $value;
        $updatePropertyMethod = 'updated' . Str::title($property);

        //support update property hook
        if (method_exists($component, $updatePropertyMethod)) {
            $component->{$updatePropertyMethod}();
        }
    }

    public function initialRender($namespace)
    {
        $component = new $namespace;

        if (method_exists($component, 'mount')) {
            $component->mount();
        }

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
