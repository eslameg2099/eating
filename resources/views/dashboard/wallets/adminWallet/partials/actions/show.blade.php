@if(method_exists($user, 'trashed') && $user->trashed())
    @can('view', $user)
        <a href="{{ route('dashboard.wallets.customersWallet.show', $user) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $user)
        <a href="{{ route('dashboard.wallets.customersWallet.show', $user) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif