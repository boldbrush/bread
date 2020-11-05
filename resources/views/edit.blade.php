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

            <form action="" method="post">
                @foreach ($editor->getFields() as $field)
                    {!! $field->render($editor->getModel()->{$field->getName()}) !!}
                @endforeach
            </form>
        </div>
    </div>
</div>
@endsection