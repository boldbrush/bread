@extends($layout)

@section('title', $editor->title())

@section('content')
<div class="table-container">
    <div class="card card-default">

        <div class="card-body">
            <h2 class="card-title">
                {{ $editor->title() }}
            </h2>

            <br>
            <hr>
            <br>

            <form action="{{ $editor->routeBuilder()->save($editor->getModel()) }}" method="post">
                @csrf
                @foreach ($editor->getFields() as $field)
                    {!! $field->render($editor->getModel()->{$field->getName()}) !!}
                @endforeach

                <button class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save
                </button>

                @if ($editor->routeBuilder()->hasBrowseRoute())
                <a class="inline-block bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{ $editor->routeBuilder()->browse() }}">
                    Exit
                </a>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection