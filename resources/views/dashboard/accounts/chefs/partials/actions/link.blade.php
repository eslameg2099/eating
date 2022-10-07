@if($chef)
    @if(method_exists($chef, 'trashed') && $chef->trashed())
        <a href="{{ route('dashboard.chefs.trashed.show', $chef) }}" class="text-decoration-none text-ellipsis">
            {{ $chef->name }}
        </a>
    @else
        <a href="{{ route('dashboard.chefs.show', $chef) }}" class="text-decoration-none text-ellipsis">
            {{ $chef->name }}
        </a>
    @endif
@else
    ---
@endif
