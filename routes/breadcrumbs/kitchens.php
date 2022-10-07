<?php

Breadcrumbs::for('dashboard.kitchens.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('kitchen.plural'), route('dashboard.kitchens.index'));
});

Breadcrumbs::for('dashboard.kitchens.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.kitchens.index');
    $breadcrumb->push(trans('kitchen.trashed'), route('dashboard.kitchens.trashed'));
});

Breadcrumbs::for('dashboard.kitchens.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.kitchens.index');
    $breadcrumb->push(trans('kitchen.actions.create'), route('dashboard.kitchens.create'));
});

Breadcrumbs::for('dashboard.kitchens.show', function ($breadcrumb, $kitchen) {
    $breadcrumb->parent('dashboard.kitchens.index');
    $breadcrumb->push($kitchen->name, route('dashboard.kitchens.show', $kitchen));
});

Breadcrumbs::for('dashboard.kitchens.edit', function ($breadcrumb, $kitchen) {
    $breadcrumb->parent('dashboard.kitchens.show', $kitchen);
    $breadcrumb->push(trans('kitchen.actions.edit'), route('dashboard.kitchens.edit', $kitchen));
});
