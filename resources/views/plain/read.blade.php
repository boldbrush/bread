@extends($layout)

@section('title', $reader->title())

@section('content')
<h1>
    {{ $reader->title() }}
</h1>

<hr>

@foreach ($reader->getFields() as $field)
    @if ($field->isVisible())
        {{ $field->label() }} : {{ $reader->getModel()->{$field->getName()} }} <br>
    @endif
@endforeach

@if ($reader->routeBuilder()->hasBrowseRoute())
<hr>
<a href="{{ $reader->routeBuilder()->browse() }}"> &larr; Back</a>
@endif

@endsection