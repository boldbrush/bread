@extends($layout)

@section('title', $adder->title())

@section('content')
<h1>
    {{ $adder->title() }}
</h1>

<hr>

<form @if ($adder->routeBuilder()->hasAddRoute()) action="{{ $adder->routeBuilder()->add() }}" @endif method="post">
    @csrf
    @foreach ($adder->getFields() as $field)
        @if ($field->isVisible() && $field->isEditable())
            {!! $field->render($adder->getModel()->{$field->getName()}) !!} <br>
        @endif
    @endforeach

    @if ($adder->routeBuilder()->hasBrowseRoute())
    <a href="{{ $adder->routeBuilder()->browse() }}">
        &larr; Exit
    </a> |
    @endif

    <button>
        Add
    </button>
</form>
@endsection