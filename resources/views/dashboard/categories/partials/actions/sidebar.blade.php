@component('dashboard::components.sidebarItem')
{{--    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Category::class])--}}
    @slot('url', route('dashboard.categories.index'))
    @slot('name', trans('category.plural'))
    @slot('active', request()->routeIs('*categories*'))
    @slot('icon', 'fas fa-layer-group')
@endcomponent
