<?php

Breadcrumbs::for('dashboard.delivery_companies.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('delivery_companies.plural'), route('dashboard.delivery_companies.index'));
});

Breadcrumbs::for('dashboard.delivery_companies.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.delivery_companies.index');
    $breadcrumb->push(trans('delivery_companies.trashed'), route('dashboard.delivery_companies.trashed'));
});

Breadcrumbs::for('dashboard.delivery_companies.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.delivery_companies.index');
    $breadcrumb->push(trans('delivery_companies.actions.create'), route('dashboard.delivery_companies.create'));
});

Breadcrumbs::for('dashboard.delivery_companies.show', function ($breadcrumb, $delivery_company) {
    $breadcrumb->parent('dashboard.delivery_companies.index');
    $breadcrumb->push($delivery_company->name, route('dashboard.delivery_companies.show', $delivery_company));
});

Breadcrumbs::for('dashboard.delivery_companies.edit', function ($breadcrumb, $delivery_company) {
    $breadcrumb->parent('dashboard.delivery_companies.show', $delivery_company);
    $breadcrumb->push(trans('delivery_companies.actions.edit'), route('dashboard.delivery_companies.edit', $delivery_company));
});
