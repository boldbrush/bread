@extends($layout)

@section('title', $browser->title())

@section('content')
<div class="bg-white pb-4 px-4 shadow rounded-md w-full">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">
                {{ $browser->title() }}
            </h2>
        </div>
        <hr>
        @if ($browser->routeBuilder()->hasAddRoute())
            <a class="float-right px-4 sm:px-8 pt-2" href="{{ $browser->routeBuilder()->add() }}">
                <svg style="display:inline-block" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg> Add new
            </a>
        @endif
        <div class="my-2 flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                    <form action="">
                        <select id="perpage-js" name="perPage"
                            class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option {{  $browser->perPageFomRequest() === 5  || $browser->perPageFomRequest() === null ? ' selected="true"' : '' }} value="5">5</option>
                            <option {{  $browser->perPageFomRequest() === 25 ? ' selected="true"' : '' }} value="25">25</option>
                            <option {{  $browser->perPageFomRequest() === 50 ? ' selected="true"' : '' }} value="50">50</option>
                        </select>
                    </form>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="block relative">
                <form action="">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input name="{{ $browser->searchTerm() }}" placeholder="Search"
                        class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </form>
            </div>
        </div>
        @if ($browser->count() === 0)
        No data found!
        @else
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            @foreach ($browser->getColumns() as $column)
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <a {{ $column->sortLink() }} class="{{  $column->getStringCssClasses() }}">
                                    {{ $column->label() }}
                                </a>
                            </th>
                            @endforeach
                            @if ($browser->routeBuilder()->hasActionRoutes())
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($browser->records() as $item)
                        <tr>
                            @foreach ($browser->getColumns() as $column)
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $item->{$column->getName()} }}
                            </td>
                            @endforeach
                            @if ($browser->routeBuilder()->hasActionRoutes())
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
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
                @if ($browser->total() > 0)
                <div
                    class="px-5 py-5 bg-white border-t items-center xs:justify-between">
                    {{ $browser->paginator()->links() }}
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
    document.getElementById('perpage-js').addEventListener("change", bread.changePerPage, false);
</script>

@if ($browser->routeBuilder()->hasDeleteRoute())
<script>
    document.documentElement.addEventListener("click", bread.handleAnchorClick, false);
</script>
@endif
@endsection
