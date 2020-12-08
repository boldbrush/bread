@extends($layout)

@section('title', $browser->title())

@section('content')
<h1>
    {{ $browser->title() }}
</h1>
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
                <a class="inline-block" href="{{ $browser->routeBuilder()->edit($item) }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif
                @if ($browser->routeBuilder()->hasReadRoute())
                <a class="inline-block" href="{{ $browser->routeBuilder()->read($item) }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
                @endif
                @if ($browser->routeBuilder()->hasDeleteRoute())
                <a class="inline-block js-delete" href="{{ $browser->routeBuilder()->delete($item) }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </a>
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if ($browser->total() > 0)
        {{ $browser->paginator()->links() }}
@endif

@if ($browser->routeBuilder()->hasDeleteRoute())
<script>
    function findParentByTagName(element, className) {
        var parent = element;
        while (parent !== null && parent.classList.value.indexOf(className) === -1) {
            parent = parent.parentElement;
        }
        return parent;
    }

    function handleAnchorClick(event) {
        event = event || window.event;
        var element = findParentByTagName(event.target, "js-delete");
        if (element) {
            event.preventDefault();
            if (window.confirm("Do you really want to delete this item?")) {
                window.location.href = element.getAttribute("href");
            }
        }
    }

    document.documentElement.addEventListener("click", handleAnchorClick, false);
</script>
@endif
@endsection