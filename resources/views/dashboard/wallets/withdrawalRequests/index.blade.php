<x-layout :title="trans('wallets.plural')" :breadcrumbs="['dashboard.wallets.withdrawals.index']">
{{--    @include('dashboard.wallets.customersWallet.partials.filter')--}}

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('orders.actions.list') ({{ count_formatted($wallets->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        <div>
                            @include('dashboard.wallets.withdrawalRequests.partials.actions.excel')
                        </div>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('wallets.attributes.id')</th>
            <th>@lang('wallets.attributes.user_name')</th>
            <th>@lang('wallets.attributes.phone')</th>
            <th>@lang('wallets.attributes.creditData')</th>
            <th class="d-none d-md-table-cell">@lang('wallets.attributes.transaction')</th>
        </tr>
        </thead>
        <tr>
        @forelse($wallets as $wallet)
            <tr>
                <td>
                    <x-check-all-withdrewal :model="$wallet"></x-check-all-withdrewal>
                </td>
                <td>
                    {{ $wallet->id }}
                </td>
                <td>
                    {{ $wallet->user->name }}
                </td>
                <td>
                    {{ $wallet->user->phone }}
                </td>
                <td class="d-none d-md-table-cell">
                    <a href="{{ route('dashboard.wallets.withdrawals.showCredit', $wallet->user) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $wallet->user->credit->account_name}}
                    </a>
                </td>
                <td> {{ price(abs($wallet->value)). ' '}} <small>ريال</small>  </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders.empty')</td>
            </tr>
        </tr>
        @endforelse

        @if($wallets->hasPages())
            @slot('footer')
                {{ $wallets->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>

