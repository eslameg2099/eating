<x-layout :title="trans('meal.plural')" :breadcrumbs="['dashboard.meals.trashed']">
    @include('dashboard.meals.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('meal.actions.list') ({{ count_formatted($meals->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-delete
                            type="{{ \App\Models\Meal::class }}"
                            :resource="trans('meal.plural')"></x-check-all-delete>
                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        <div>
                            @include('dashboard.meals.partials.actions.create')
                        </div>
                        @include('dashboard.meals.partials.actions.trashed')
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('id')</th>
            <th>@lang('meal.attributes.name')</th>
            <th>@lang('meal.attributes.kitchen_id')</th>
            <th>@lang('meal.attributes.category')</th>
            <th>@lang('meal.attributes.cost')</th>
            <th>@lang('meal.attributes.cost_after_discount')</th>
            <th>@lang('meal.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($meals as $meal)
            <tr>
                <td>
                    <x-check-all-item :model="$meal"></x-check-all-item>
                </td>
                <td>
                    {{$meal->id}}
                </td>
                <td>
                    <img src="{{ $meal->getFirstMediaUrl('Meal') }}"
                         alt="*"
                         class="img-circle img-size-32 mr-2">
                    <a href="{{ route('dashboard.meals.show', $meal) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $meal->name }}
                    </a>
                </td>
                <td>{{ $meal->kitchen->name ?? '--' }}</td>
                <td>{{ $meal->category->title ?? '--' }}</td>
                <td>{{ $meal->cost ?? '--' }}</td>
                <td>{{ $meal->cost_after_discount ?? '--' }}</td>
                <td>{{ $meal->created_at ?? '--' }}</td>
                <td style="width: 160px">
                    @include('dashboard.meals.partials.actions.show', ['meal' => $meal])
                    @include('dashboard.meals.partials.actions.restore', ['meal' => $meal])
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('meal.empty')</td>
            </tr>
        @endforelse

        @if($meals->hasPages())
            @slot('footer')
                {{ $meals->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
