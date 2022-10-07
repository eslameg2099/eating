<x-layout :title="$coupon->title" :breadcrumbs="['dashboard.coupons.show', $coupon]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('coupons.attributes.title')</th>
                        <td>{{ $coupon->title }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('coupons.attributes.discount_percentage')</th>
                        <td>{{ $coupon->discount_percentage }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('coupons.attributes.limit')</th>
                        <td>{{ $coupon->limit }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('coupons.attributes.expire_date')</th>
                        <td>{{ $coupon->expire_date }}</td>
                    </tr>

                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.coupons.partials.actions.edit')
                    @include('dashboard.coupons.partials.actions.delete')
                    @include('dashboard.coupons.partials.actions.restore')
                    @include('dashboard.coupons.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
