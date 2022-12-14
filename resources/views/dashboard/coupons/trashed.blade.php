<x-layout :title="trans('coupons.trashed')" :breadcrumbs="['dashboard.coupons.trashed']">
    @include('dashboard.coupons.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('coupons.actions.list') ({{ $coupons->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <x-check-all-force-delete
                    type="{{ \App\Models\Coupon::class }}"
                    :resource="trans('coupons.plural')"></x-check-all-force-delete>
            <x-check-all-restore
                    type="{{ \App\Models\Coupon::class }}"
                    :resource="trans('coupons.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('coupons.attributes.title')</th>
            <th>@lang('coupons.attributes.discount_percentage')</th>
            <th>@lang('coupons.attributes.expire_date')</th>
            <th>@lang('coupons.attributes.limit')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
            <tbody>
            @forelse($coupons as $coupon)
                <tr>
                    <td class="text-center">
                        <x-check-all-item :model="$coupon"></x-check-all-item>
                    </td>
                    <td>
                        {{ $coupon->title }}
                        </a>
                    </td>
                    <td>
                        {{$coupon->discount_percentage}} %
                    </td>
                    <td>
                        {{$coupon->expire_date}}
                    </td>
                    <td>
                        {{$coupon->limit}}
                    </td>
                <td style="width: 160px">
                    @include('dashboard.coupons.partials.actions.show')
                    @include('dashboard.coupons.partials.actions.restore')
                    @include('dashboard.coupons.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('coupons.empty')</td>
            </tr>
        @endforelse

        @if($coupons->hasPages())
            @slot('footer')
                {{ $coupons->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
