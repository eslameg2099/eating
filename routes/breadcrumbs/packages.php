<?php

Breadcrumbs::for('dashboard.packages.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('packages.plural'), route('dashboard.packages.index'));
});

Breadcrumbs::for('dashboard.packages.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.packages.index');
    $breadcrumb->push(trans('packages.trashed'), route('dashboard.packages.trashed'));
});

Breadcrumbs::for('dashboard.packages.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.packages.index');
    $breadcrumb->push(trans('packages.actions.create'), route('dashboard.packages.create'));
});

Breadcrumbs::for('dashboard.packages.show', function ($breadcrumb, $package) {
    $breadcrumb->parent('dashboard.packages.index');
    $breadcrumb->push($package->name, route('dashboard.packages.show', $package));
});

Breadcrumbs::for('dashboard.packages.edit', function ($breadcrumb, $package) {
    $breadcrumb->parent('dashboard.packages.show', $package);
    $breadcrumb->push(trans('packages.actions.edit'), route('dashboard.packages.edit', $package));
});
