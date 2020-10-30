@extends($layout)

@section('title', $reader->title())

@section('content')
<div class="table-container">
    <div class="card card-default">

        <div class="card-body">
            <h2 class="card-title">
                {{ $reader->title() }}
            </h2>
        </div>
    </div>
</div>
@endsection