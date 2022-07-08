<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >
    <title>Document</title>
</head>

<body>
    {!!livewire("App\Livewire\Components\Counter")!!}



    @php
    function getProperties($component){
        $properties=[];
        $class = new ReflectionClass($component);
        foreach($class->getProperties(ReflectionProperty::IS_PUBLIC) as $eachProperty){
        $properties[$eachProperty->getName()]=$eachProperty->getValue(new $component);
        }
        return $properties;
    }

    function livewire($component){
        $class=new $component;
        return Blade::render($class->render(),
        getProperties($component)
        );
    }
    @endphp
</body>

</html>