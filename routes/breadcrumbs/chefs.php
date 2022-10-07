<?php

Breadcrumbs::for('dashboard.chefs.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('chefs.plural'), route('dashboard.chefs.index'));
});

Breadcrumbs::for('dashboard.chefs.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.chefs.index');
    $breadcrumb->push(trans('chefs.trashed'), route('dashboard.chefs.trashed'));
});

Breadcrumbs::for('dashboard.chefs.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.chefs.index');
    $breadcrumb->push(trans('chefs.actions.create'), route('dashboard.chefs.create'));
});

Breadcrumbs::for('dashboard.chefs.show', function ($breadcrumb, $chef) {
    $breadcrumb->parent('dashboard.chefs.index');
    $breadcrumb->push($chef->name, route('dashboard.chefs.show', $chef));
});

Breadcrumbs::for('dashboard.chefs.edit', function ($breadcrumb, $chef) {
    $breadcrumb->parent('dashboard.chefs.show', $chef);
    $breadcrumb->push(trans('chefs.actions.edit'), route('dashboard.chefs.edit', $chef));
});
