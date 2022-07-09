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
    @livewire("App\Livewire\Components\Counter")



    <script>
        let snapshotElements=document.querySelectorAll('[wire\\:snapshot]');
        snapshotElements.forEach(el=>{
            let snapshot=JSON.parse(el.getAttribute('wire:snapshot'));
            console.log(snapshot)
        })
    </script>
</body>

</html>