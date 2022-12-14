@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.home'))
    @slot('name', trans('dashboard.home'))
    @slot('icon', 'fas fa-tachometer-alt')
    @slot('active', request()->routeIs('dashboard.home'))
@endcomponent

@include('dashboard.accounts.sidebar')
@include('dashboard.cities.partials.actions.sidebar')
@include('dashboard.kitchens.sidebar')
@include('dashboard.orders.sidebar')
@include('dashboard.wallets.sidebar')
@include('dashboard.meals.partials.actions.sidebar')
@include('dashboard.categories.partials.actions.sidebar')
@include('dashboard.kitchenSponsors.partials.actions.sidebar')
@include('dashboard.SponsorDurations.partials.actions.sidebar')
@include('dashboard.reports.partials.actions.sidebar')
@include('dashboard.coupons.partials.actions.sidebar')
@include('dashboard.packages.partials.actions.sidebar')
@include('dashboard.delivery_companies.partials.actions.sidebar')
@include('dashboard.paymenttype.partials.actions.sidebar')
{{-- The sidebar of generated crud will set here: Don't remove this line --}}
@include('dashboard.feedback.partials.actions.sidebar')
@include('dashboard.notifications.partials.actions.sidebar')
@include('dashboard.settings.sidebar')
