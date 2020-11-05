@extends($layout)

@section('title', $reader->title())

@section('content')
<div class="table-container">
    <div class="card card-default">

        <div class="card-body">
            <h2 class="card-title">
                {{ $reader->title() }}
            </h2>

            <br>
            <hr>
            <br>

            <form action="">
                @foreach ($reader->getFields() as $field)
                    {{ $field->label() }} : {{ $reader->getModel()->{$field->getName()} }} <br>
                @endforeach
            </form>
        </div>
    </div>
</div>
@endsection