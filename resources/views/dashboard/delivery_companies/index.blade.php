<x-layout :title="trans('delivery_companies.plural')" :breadcrumbs="['dashboard.delivery_companies.index']">
    @include('dashboard.delivery_companies.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('delivery_companies.actions.list') ({{ $delivery_companies->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\DeliveryCompany::class }}"
                        :resource="trans('delivery_companies.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.delivery_companies.partials.actions.create')
                    @include('dashboard.delivery_companies.partials.actions.trashed')
                </div>
            </div>
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
                    <a href="{{ route('dashboard.delivery_companies.show', $delivery_company) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $delivery_company->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.delivery_companies.partials.actions.show')
                    @include('dashboard.delivery_companies.partials.actions.edit')
                    @include('dashboard.delivery_companies.partials.actions.delete')
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
