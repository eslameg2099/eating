<?php

Breadcrumbs::for('dashboard.specialOrders.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('orders.plural'), route('dashboard.specialOrders.index'));
});

Breadcrumbs::for('dashboard.specialOrders.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.specialOrders.index');
    $breadcrumb->push(trans('orders.trashed'), route('dashboard.specialOrders.trashed'));
});

Breadcrumbs::for('dashboard.specialOrders.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.specialOrders.index');
    $breadcrumb->push(trans('orders.actions.create'), route('dashboard.specialOrders.create'));
});

Breadcrumbs::for('dashboard.specialOrders.show', function ($breadcrumb, $special_order) {
    $breadcrumb->parent('dashboard.specialOrders.index');
    $breadcrumb->push('orders', route('dashboard.specialOrders.show', $special_order));
});

Breadcrumbs::for('dashboard.specialOrders.edit', function ($breadcrumb, $special_order) {
    $breadcrumb->parent('dashboard.specialOrders.show', $special_order);
    $breadcrumb->push(trans('orders.actions.edit'), route('dashboard.specialOrders.edit', $special_order));
});
