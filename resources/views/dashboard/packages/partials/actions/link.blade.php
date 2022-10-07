@if($package)
    @if(method_exists($package, 'trashed') && $package->trashed())
        <a href="{{ route('dashboard.packages.trashed.show', $package) }}" class="text-decoration-none text-ellipsis">
            {{ $package->name }}
        </a>
    @else
        <a href="{{ route('dashboard.packages.show', $package) }}" class="text-decoration-none text-ellipsis">
            {{ $package->name }}
        </a>
    @endif
@else
    ---
@endif