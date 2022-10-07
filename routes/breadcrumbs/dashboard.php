<?php

Breadcrumbs::for('dashboard.home', function ($breadcrumb) {
    $breadcrumb->push(trans('dashboard.home'), route('dashboard.home'));
});



Breadcrumbs::for('dashboard.types.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('types.plural'), route('dashboard.types.index'));
});


Breadcrumbs::for('dashboard.types.edit', function ($breadcrumb, $city) {
    $breadcrumb->parent('dashboard.types.show', $city);
    $breadcrumb->push(trans('types.actions.edit'), route('dashboard.types.edit', $city));
});

Breadcrumbs::for('dashboard.types.show', function ($breadcrumb, $city) {
    $breadcrumb->parent('dashboard.types.index');
    $breadcrumb->push($city->name, route('dashboard.types.show', $city));
});
