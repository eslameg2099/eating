<x-layout :title="$user->name" :breadcrumbs="['dashboard.wallets.withdrawals.showCredit', $user]">
    <div class="container">
    <div class="row">
        <div class="col">
            @component('dashboard::components.box')
                @slot('bodyClass', 'p-0')
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('admins.attributes.avatar')</th>
                    <td>
                        @if($user->getFirstMedia('avatars'))
                            <file-preview :media="{{ $user->getMediaResource('avatars') }}"></file-preview>
                        @else
                            <img src="{{ $user->getAvatar() }}"
                                 class="img img-size-64"
                                 alt="{{ $user->name }}">
                        @endif
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.user_id')</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.user_name')</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.balance')</th>
                    <td>{{ $user->wallet()->Balance() }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.total_charge')</th>
                    <td>{{ $user->wallet()->Deposit() }}</td>
                </tr>

                <tr>
                    <th width="200">@lang('wallets.attributes.transaction_count')</th>
                    <td>{{ $user->wallet->count() ?? '--'}}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.credit.account-name')</th>
                    <td>{{ $credit->account_name ?? '--'}}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.credit.bank_name')</th>
                    <td>{{  $credit->bank_name ?? '--'}}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.credit.account_number')</th>
                    <td>{{ $credit->account_number ?? '--'}}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.credit.iban_number')</th>
                    <td>{{ $credit->iban_number ?? '--'}}</td>
                </tr>


                </tbody>
            </table>
        </div>

    </div>
    </div>
                @endcomponent
            </div>
        </div>
    </div>

</x-layout>
