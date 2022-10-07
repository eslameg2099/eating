<x-layout :title="trans('wallets.plural')" :breadcrumbs="['dashboard.wallets.customersWallet.index']">
    @include('dashboard.wallets.customersWallet.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('orders.actions.list') ({{ count_formatted($users->total()) }})
        @endslot

        <thead>

        <tr>
            <th>@lang('wallets.attributes.id')</th>
            <th>@lang('wallets.attributes.user_name')</th>
            <th class="d-none d-md-table-cell">@lang('wallets.attributes.balance')</th>
            <th>@lang('wallets.attributes.total_charge')</th>
            <th>@lang('wallets.attributes.pending')</th>
            <th>@lang('wallets.attributes.transaction_count')</th>
            <th style="width: 160px">@lang('wallets.attributes.operations')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>
                    {{ $user->id }}
                </td>
                <td>
                    {{ $user->name }}
                </td>

                <td class="d-none d-md-table-cell">
                    {{ price($user->wallet()->Balance()). ' '}} <small>ريال</small>
                </td>
                <td> {{ price($user->wallet()->Deposit()). ' '}} <small>ريال</small>  </td>
                <td>{{ price($user->wallet()->PendingWithdrawal()). ' '}} <small>ريال</small> </td>
                <td>{{ $user->wallet->count() }}</td>

                <td style="width: 160px">
                    @include('dashboard.wallets.chefsWallet.partials.actions.show')
{{--                    @include('dashboard.wallets.customersWallet.partials.actions.edit')--}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders.empty')</td>
            </tr>
        @endforelse

        @if($users->hasPages())
            @slot('footer')
                {{ $users->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>

