<?php

Breadcrumbs::for('dashboard.coupons.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('coupons.plural'), route('dashboard.coupons.index'));
});

Breadcrumbs::for('dashboard.coupons.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.coupons.index');
    $breadcrumb->push(trans('coupons.trashed'), route('dashboard.coupons.trashed'));
});

Breadcrumbs::for('dashboard.coupons.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.coupons.index');
    $breadcrumb->push(trans('coupons.actions.create'), route('dashboard.coupons.create'));
});

Breadcrumbs::for('dashboard.coupons.show', function ($breadcrumb, $coupon) {
    $breadcrumb->parent('dashboard.coupons.index');
    $breadcrumb->push($coupon->title, route('dashboard.coupons.show', $coupon));
});

Breadcrumbs::for('dashboard.coupons.edit', function ($breadcrumb, $coupon) {
    $breadcrumb->parent('dashboard.coupons.show', $coupon);
    $breadcrumb->push(trans('coupons.actions.edit'), route('dashboard.coupons.edit', $coupon));
});
