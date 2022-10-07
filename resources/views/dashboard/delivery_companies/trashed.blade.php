<x-layout :title="trans('delivery_companies.trashed')" :breadcrumbs="['dashboard.delivery_companies.trashed']">
    @include('dashboard.delivery_companies.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('delivery_companies.actions.list') ({{ $delivery_companies->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <x-check-all-force-delete
                    type="{{ \App\Models\DeliveryCompany::class }}"
                    :resource="trans('delivery_companies.plural')"></x-check-all-force-delete>
            <x-check-all-restore
                    type="{{ \App\Models\DeliveryCompany::class }}"
                    :resource="trans('delivery_companies.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('delivery_companies.attributes.name')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($delivery_companies as $delivery_company)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$delivery_company"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.delivery_companies.trashed.show', $delivery_company) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $delivery_company->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.delivery_companies.partials.actions.show')
                    @include('dashboard.delivery_companies.partials.actions.restore')
                    @include('dashboard.delivery_companies.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('delivery_companies.empty')</td>
            </tr>
        @endforelse

        @if($delivery_companies->hasPages())
            @slot('footer')
                {{ $delivery_companies->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
