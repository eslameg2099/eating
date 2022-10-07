<x-layout :title="$kitchenDuration->kitchen->name" :breadcrumbs="['dashboard.kitchenDurations.show', $kitchenDuration]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('kitchensponsor.attributes.kitchen_name')</th>
                        <td>{{ $kitchenDuration->kitchen->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('kitchensponsor.attributes.start_date')</th>
                        <td>{{ $kitchenDuration->start_date  ?? '--'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('kitchensponsor.attributes.end_date')</th>
                        <td>{{ $kitchenDuration->end_date  ?? '--'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('kitchensponsor.attributes.total_cost')</th>
                        <td>{{ $kitchenDuration->cost }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('kitchensponsor.attributes.created_at')</th>
                        <td>{{ $kitchenDuration->created_at }}</td>
                    </tr>

                    <tr>
                        <th width="200">@lang('kitchensponsor.attributes.avatar')</th>
                        <td>
                            @if($kitchenDuration->kitchenSponsor->first()->getFirstMedia('default'))
                                <file-preview :media="{{ $kitchenDuration->kitchenSponsor->first()->getMediaResource('default') }}"></file-preview>
                            @else
                                '--'
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                @component('dashboard::components.box')
                    @slot('class', 'p-0')
                    @slot('bodyClass', 'p-0')
<table class="table table-striped table-middle">
                <thead>

                <tr>
                    <th>@lang('kitchensponsor.attributes.sponsor_title')</th>
                    <th>@lang('kitchensponsor.attributes.start_date')</th>
                    <th>@lang('kitchensponsor.attributes.end_date')</th>
                    <th>@lang('kitchensponsor.attributes.paid')</th>
                    <th>@lang('kitchensponsor.attributes.accepted')</th>
                    <th>@lang('kitchensponsor.attributes.created_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($kitchenDuration->kitchenSponsor as $kitchenSponsor)
                    <tr>
                        <td>
                            <img src="{{ $kitchenDuration->kitchenSponsor->first()->getFirstMediaUrl() }}"
                                 alt="*"
                                 class="img-circle img-size-32 mr-2">
                            <a href="{{ route('dashboard.kitchenDurations.show', $kitchenDuration) }}"
                               class="text-decoration-none text-ellipsis">
                                {{ $kitchenDuration->kitchenSponsor->last()->sponsor_duration->title }}
                            </a>
                        </td>
                        <td>{{ $kitchenSponsor->start_date ?? '--' }}</td>
                        <td>{{ $kitchenSponsor->end_date ?? '--' }}</td>
                        <td>{{ $kitchenSponsor->paid ? 'مدفوع' : 'غير مدفوع' }}</td>
                        <td>{{ $kitchenSponsor->accepted ? 'مقبول' : 'معلق'}}</td>
                        <td>{{ $kitchenSponsor->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('kitchensponsor.empty')</td>
                    </tr>
                @endforelse
</table>
                @endcomponent
                @slot('footer')
{{--                    @include('dashboard.kitchenDurations.partials.actions.delete')--}}
                    @include('dashboard.kitchenSponsors.partials.actions.edit', ['kitchenDuration' => $kitchenDuration])
{{--                    @include('dashboard.kitchenDurations.partials.actions.restore')--}}
{{--                    @include('dashboard.kitchenDurations.partials.actions.forceDelete')--}}
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
