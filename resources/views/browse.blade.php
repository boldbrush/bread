@extends('bread::master')

@section('title', $browser->title())

@section('content')
<div class="table-container">
    <div class="card card-default">

        <div class="card-body">
            <h2 class="card-title">
                {{ $browser->title() }}
            </h2>
            <div class="col-sm-12">
                <div class="table-responsive">
                    @if ($browser->count() === 0)
                    No data found!
                    @else
                    <table class="table-auto">
                        <thead>
                            <tr>
                                @foreach ($browser->rowHeaders() as $column)
                                <th scope="row">{{ $column }}</th>
                                @endforeach
                                @if ($browser->hasEditRoute())
                                <th scope="col">edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($browser->records() as $item)
                            <tr>
                                @foreach ($browser->getColumns() as $column)
                                <td class="border px-4 py-2">{{ $item->{$column} }}</td>
                                @endforeach
                                @if ($browser->hasEditRoute())
                                <td><a href="{{ $item->editUrl }}">edit</a></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            @if ($browser->total() > 0)
            <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12">
                    &nbsp;
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    {{ $browser->paginator()->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection