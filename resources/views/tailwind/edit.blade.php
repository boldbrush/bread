@extends($layout)

@section('title', $editor->title())

@section('content')
<h1>
    {{ $editor->title() }}
</h1>

<hr>

<form action="{{ $editor->routeBuilder()->save($editor->getModel()) }}" method="post">
    @csrf
    @foreach ($editor->getFields() as $field)
        @if ($field->isVisible()  && $field->isEditable())
            {!! $field->render($editor->getModel()->{$field->getName()}) !!} <br>
        @endif
    @endforeach

    @if ($editor->routeBuilder()->hasBrowseRoute())
    <a href="{{ $editor->routeBuilder()->browse() }}">
        &larr; Exit
    </a> |
    @endif

    <button>
        Save
    </button>
</form>
@endsection