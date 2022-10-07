@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Meal::class])
    @slot('url', route('dashboard.meals.index'))
    @slot('name', trans('meal.plural'))
    @slot('active', request()->routeIs('*meals*'))
    @slot('icon', 'fas fa-utensils')
@endcomponent
