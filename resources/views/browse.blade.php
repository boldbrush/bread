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
                                @if ($browser->routeBuilder()->hasActionRoutes())
                                <th scope="row">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($browser->records() as $item)
                            <tr>
                                @foreach ($browser->getColumns() as $column)
                                <td class="border px-4 py-2">{{ $item->{$column} }}</td>
                                @endforeach
                                @if ($browser->routeBuilder()->hasActionRoutes())
                                <td class="border px-4 py-2">
                                    @if ($browser->routeBuilder()->hasEditRoute())
                                    <a href="{{ $browser->routeBuilder()->edit($item) }}">Edit</a>
                                    @endif
                                    @if ($browser->routeBuilder()->hasReadRoute())
                                    <a href="{{ $browser->routeBuilder()->read($item) }}">Read</a>
                                    @endif
                                </td>
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