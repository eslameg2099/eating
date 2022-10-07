<?php

Breadcrumbs::for('dashboard.kitchenDurations.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('kitchen.plural'), route('dashboard.kitchenDurations.index'));
});

Breadcrumbs::for('dashboard.kitchenDurations.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.kitchenDurations.index');
    $breadcrumb->push(trans('kitchen.trashed'), route('dashboard.kitchenDurations.trashed'));
});

Breadcrumbs::for('dashboard.kitchenDurations.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.kitchenDurations.index');
    $breadcrumb->push(trans('kitchen.actions.create'), route('dashboard.kitchenDurations.create'));
});
Breadcrumbs::for('dashboard.kitchenDurations.show', function ($breadcrumb, $kitchenDuration) {
    $breadcrumb->parent('dashboard.kitchenDurations.index');
    $breadcrumb->push($kitchenDuration->kitchen->name, route('dashboard.kitchenDurations.show', $kitchenDuration));
});

Breadcrumbs::for('dashboard.kitchenDurations.edit', function ($breadcrumb, $kitchenDuration) {
    $breadcrumb->parent('dashboard.kitchenDurations.show', $kitchenDuration);
    $breadcrumb->push(trans('kitchensponsor.actions.edit'), route('dashboard.kitchenDurations.edit', $kitchenDuration));
});
