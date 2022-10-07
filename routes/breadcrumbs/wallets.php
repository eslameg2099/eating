<?php

Breadcrumbs::for('dashboard.wallets.customersWallet.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('wallets.plural'), route('dashboard.wallets.customersWallet.index'));
});
Breadcrumbs::for('dashboard.wallets.chefsWallet.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('wallets.plural'), route('dashboard.wallets.customersWallet.index'));
});

Breadcrumbs::for('dashboard.wallets.customersWallet.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.wallets.customersWallet.index');
    $breadcrumb->push(trans('category.trashed'), route('dashboard.wallets.trashed'));
});
Breadcrumbs::for('dashboard.wallets.chefsWallet.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.wallets.chefsWallet.index');
    $breadcrumb->push(trans('category.trashed'), route('dashboard.wallets.trashed'));
});

Breadcrumbs::for('dashboard.wallets.customersWallet.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.wallets.customersWallet.index');
    $breadcrumb->push(trans('category.actions.create'), route('dashboard.wallets.create'));
});
Breadcrumbs::for('dashboard.wallets.chefsWallet.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.wallets.chefsWallet.index');
    $breadcrumb->push(trans('category.actions.create'), route('dashboard.wallets.create'));
});

Breadcrumbs::for('dashboard.wallets.customersWallet.show', function ($breadcrumb, $user) {
    $breadcrumb->parent('dashboard.wallets.customersWallet.index');
    $breadcrumb->push($user->name, route('dashboard.wallets.customersWallet.show', $user));
});
Breadcrumbs::for('dashboard.wallets.chefsWallet.show', function ($breadcrumb, $user) {
    $breadcrumb->parent('dashboard.wallets.chefsWallet.index');
    $breadcrumb->push($user->name, route('dashboard.wallets.chefsWallet.show', $user));
});
Breadcrumbs::for('dashboard.wallets.adminsWallet.show', function ($breadcrumb, $user) {
    //$breadcrumb->parent('dashboard.wallets.adminsWallet.index');
    $breadcrumb->push($user->name, route('dashboard.wallets.adminsWallet.show', $user));
});
Breadcrumbs::for('dashboard.wallets.withdrawals.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('wallets.withdrawalRequests'), route('dashboard.wallets.withdrawals.index'));
});
Breadcrumbs::for('dashboard.wallets.withdrawals.showCredit', function ($breadcrumb, $user) {
    $breadcrumb->parent('dashboard.wallets.withdrawals.index');
    $breadcrumb->push($user->name, route('dashboard.wallets.withdrawals.showCredit', $user));
});


//Breadcrumbs::for('dashboard.wallets.edit', function ($breadcrumb, $wallet) {
//    $breadcrumb->parent('dashboard.wallets.customersWallet.show', $wallet);
//    $breadcrumb->push(trans('category.actions.edit'), route('dashboard.wallets.edit', $wallet));
//});
