<?php

Breadcrumbs::for('dashboard.meals.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('meal.plural'), route('dashboard.meals.index'));
});

Breadcrumbs::for('dashboard.meals.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.meals.index');
    $breadcrumb->push(trans('meal.trashed'), route('dashboard.meals.trashed'));
});

Breadcrumbs::for('dashboard.meals.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.meals.index');
    $breadcrumb->push(trans('meal.actions.create'), route('dashboard.meals.create'));
});

Breadcrumbs::for('dashboard.meals.show', function ($breadcrumb, $meal) {
    $breadcrumb->parent('dashboard.meals.index');
    $breadcrumb->push($meal->name, route('dashboard.meals.show', $meal));
});

Breadcrumbs::for('dashboard.meals.edit', function ($breadcrumb, $meal) {
    $breadcrumb->parent('dashboard.meals.show', $meal);
    $breadcrumb->push(trans('meal.actions.edit'), route('dashboard.meals.edit', $meal));
});
