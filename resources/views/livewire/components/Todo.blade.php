<div>
    <h1>Todos</h1>
    <input
        type="text"
        placeholder="type here ...."
    >
    @foreach($todos as $todo)
    <h3>{{$todo}}</h3>
    @endforeach

    <button wire:click="addTodo">add todo</button>
</div>