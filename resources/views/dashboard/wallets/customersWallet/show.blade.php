<x-layout :title="$user->name" :breadcrumbs="['dashboard.wallets.customersWallet.show', $user]">
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
                    <th width="200">@lang('wallets.attributes.id')</th>
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
                    <th width="200">@lang('wallets.attributes.pending')</th>
                    <td>{{ $user->wallet()->PendingWithdrawal() }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('wallets.attributes.transaction_count')</th>
                    <td>{{ $user->wallet->count() ?? '--'}}</td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>
    </div>
    <div class="col">

        <div class="card card-gray card-outline">
            <div class="card-header">
                <h3 class="card-title m-0">اضافة للمحفظة</h3>
            </div>
        <div class="card-body">
            {{ BsForm::post('dashboard/wallet/admin/transfer/'.$user->id) }}
            {{BsForm::number('transaction')->label(trans('wallets.attributes.transaction'))->required()->min(1)}}
            {{BsForm::select('title')->options(trans('wallets.titles'))->label(trans('wallets.attributes.title'))->placeholder(__('اختر'))->required()}}
            {{BsForm::text('note')->label(trans('wallets.attributes.note'))->required()}}
            <button type="submit" class="btn btn-primary btn-sm">
                @lang('wallets.submit')
            </button>
        </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @component('dashboard::components.table-box')

                    <thead>

                    <tr>
                        <th>@lang('wallets.attributes.id')</th>
                        <th>@lang('wallets.attributes.title')</th>
                        <th class="d-none d-md-table-cell">@lang('wallets.attributes.transaction')</th>
                        <th>@lang('wallets.attributes.confirmed')</th>
                        <th>@lang('wallets.attributes.status')</th>
                        <th>@lang('wallets.attributes.note')</th>
                        <th>@lang('wallets.attributes.created_at')</th>
                        {{--                <th style="width: 160px">@lang('wallets.attributes.operations')</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($wallets as $wallet)
                        <tr>
                            <td>
                                {{ $wallet->id }}
                            </td>
                            <td>
                                {{ $wallet->title }}
                            </td>

                            @if($wallet->transaction > 0)
                                <td class="d-none d-md-table-cell">
                                    {{ price(abs($wallet->transaction)). ' '}} <small>ريال</small>
                                </td>
                            @else
                                <td class="d-none d-md-table-cell text-danger">
                                    {{ price(abs($wallet->transaction)). ' '}} <small>ريال</small>
                                </td>
                            @endif
                            <td> {{ $wallet->confirmed ? 'تم' : 'معلق'}} </td>
                            <td>{{ $wallet->ReadableStatus()}} </td>
                            <td>{{ $wallet->note ?? '--'}} </td>
                            <td>{{ $wallet->created_at }}</td>

                            <td style="width: 160px">
                                {{--                        @include('dashboard.wallets.customersWallet.partials.actions.show')--}}
                                {{--                    @include('dashboard.wallets.customersWallet.partials.actions.edit')--}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100" class="text-center">@lang('orders.empty')</td>
                        </tr>
                    @endforelse

                    </tbody>
                @endcomponent

                @slot('footer')
                    {{--            @include('dashboard.accounts.admins.partials.actions.edit')--}}
                @endslot
                @endcomponent
            </div>
        </div>
    </div>

</x-layout>
