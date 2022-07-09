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
            el.addEventListener('click',(el)=>{
                if(!el.target.hasAttribute('wire:click')) return 
               //this is the wire:click button handler
               let callMethod=el.target.getAttribute('wire:click');
               fetch('/livewire',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({snapshot,callMethod})
               })
            })
        })
    </script>
</body>

</html>