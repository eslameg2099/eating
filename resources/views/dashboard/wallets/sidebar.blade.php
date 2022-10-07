@if(Gate::allows('viewAny', \App\Models\SpecialOrder::class))
    @component('dashboard::components.sidebarItem')
        @slot('url', '#')
        @slot('name', trans('wallets.plural'))
        @slot('active', request()->routeIs('*wallets*'))
        @slot('icon', 'fas fa-wallet')
        @slot('badge', count_formatted(\App\Models\Withdrawal::holding()->count()) ?: null)
        @slot('tree', [
             [
                'name' => trans('wallets.Admin'),
                'url' => route('dashboard.wallets.adminsWallet.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Wallet::class],
                'active' => request()->routeIs('*wallets.adminsWallet*'),
            ],
            [
                'name' => trans('wallets.plural_customers'),
                'url' => route('dashboard.wallets.customersWallet.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Wallet::class],
                'active' => request()->routeIs('*wallets.customersWallet*'),
            ],
            [
                'name' => trans('wallets.plural_chefs'),
                'url' => route('dashboard.wallets.chefsWallet.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Wallet::class],
                'active' => request()->routeIs('*wallets.chefsWallet*'),
            ],
             [
                'name' => trans('wallets.withdrawalRequests'),
                'url' => route('dashboard.wallets.withdrawals.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Wallet::class],
                'active' => request()->routeIs('*wallets.withdrawals*'),
                'badge' => count_formatted(\App\Models\Withdrawal::holding()->count()) ?: null,
            ],

        ])
    @endcomponent
@endif
