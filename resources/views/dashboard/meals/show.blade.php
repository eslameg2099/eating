<x-layout :title="$meal->name" :breadcrumbs="['dashboard.meals.show', $meal]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('meal.attributes.name')</th>
                        <td>{{ $meal->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.kitchen_id')</th>
                        <td>{{ $meal->kitchen->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.chef_id')</th>
                        <td>{{ $meal->kitchen->user->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.category_id')</th>
                        <td>{{ $meal->category->title }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.description')</th>
                        <td>{{ $meal->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.cost')</th>
                        <td>{{ $meal->cost }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.cost_after_discount')</th>
                        <td>{{ $meal->cost_after_discount ?? '--'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.rate')</th>
                        @if($meal->votes->count())
                            <td>{{ ($meal->votes->sum('rate') / ($meal->votes->count() ?? 1)) .'/ 5'?? '--'}}</td>
                        @else
                            <td>{{ 0 .'/ 5'?? '--'}}</td>
                        @endif
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.order_count')</th>
                        <td>{{ $meal->orderItem->count()?? '--'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('meal.attributes.created_at')</th>
                        <td>{{ $meal->created_at ?? '--'}}</td>
                    </tr>
                    @if($meal->getFirstMedia())
                        <tr>
                            <th width="200">@lang('meal.attributes.images')</th>
                            <td>
                                <file-preview :media="{{ $meal->getMediaResource() }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    @if($meal->getMedia('Meal')->count())
                        <tr>
                            <th width="200">@lang('meal.attributes.images')</th>
                            <td>
                                <file-preview :media="{{ $meal->getMediaResource('Meal') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.meals.partials.actions.delete', ['meal' => $meal])
                    @include('dashboard.meals.partials.actions.edit')
                    @include('dashboard.meals.partials.actions.restore')
{{--                    @include('dashboard.meals.partials.actions.forceDelete')--}}
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
