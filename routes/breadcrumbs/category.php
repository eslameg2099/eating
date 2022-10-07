<?php

Breadcrumbs::for('dashboard.categories.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('category.plural'), route('dashboard.categories.index'));
});

Breadcrumbs::for('dashboard.categories.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.categories.index');
    $breadcrumb->push(trans('category.trashed'), route('dashboard.categories.trashed'));
});

Breadcrumbs::for('dashboard.categories.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.categories.index');
    $breadcrumb->push(trans('category.actions.create'), route('dashboard.categories.create'));
});

Breadcrumbs::for('dashboard.categories.show', function ($breadcrumb, $category) {
    $breadcrumb->parent('dashboard.categories.index');
    $breadcrumb->push($category->title, route('dashboard.categories.show', $category));
});

Breadcrumbs::for('dashboard.categories.edit', function ($breadcrumb, $category) {
    $breadcrumb->parent('dashboard.categories.show', $category);
    $breadcrumb->push(trans('category.actions.edit'), route('dashboard.categories.edit', $category));
});
