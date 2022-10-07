<x-layout :title="$sponsorDuration->title" :breadcrumbs="['dashboard.sponsorDurations.show', $sponsorDuration]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('sponsorship.attributes.title')</th>
                        <td>{{ $sponsorDuration->title }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('sponsorship.attributes.duration')</th>
                        <td>{{ $sponsorDuration->duration . ' ' . $sponsorDuration->duration_type  ?? '--'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('sponsorship.attributes.currency')</th>
                        <td>{{ $sponsorDuration->currency  ?? '--'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('sponsorship.attributes.cost')</th>
                        <td>{{ $sponsorDuration->cost }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('sponsorship.attributes.active')</th>
                        <td>{{ $sponsorDuration->active ? 'مفعل' : 'غير مفعل' }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('sponsorship.attributes.created_at')</th>
                        <td>{{ $sponsorDuration->created_at }}</td>
                    </tr>
                    </tbody>
                </table>
                @slot('footer')
{{--                    @include('dashboard.SponsorDurations.partials.actions.delete')--}}
{{--                    @include('dashboard.SponsorDurations.partials.actions.edit', ['kitchenDuration' => $sponsorDuration])--}}
{{--                    @include('dashboard.SponsorDurations.partials.actions.restore')--}}
{{--                    @include('dashboard.SponsorDurations.partials.actions.forceDelete')--}}
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
