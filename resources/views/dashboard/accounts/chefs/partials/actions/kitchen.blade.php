@if($chef->kitchen()->exists())
    <a href="{{ route('dashboard.kitchens.show', $chef->kitchen) }}"
   title="@lang('kitchen.singular')"
   class="btn btn-outline-success btn-sm">
    <i class="nav-icon fas fa-store"></i>
</a>
@endif

