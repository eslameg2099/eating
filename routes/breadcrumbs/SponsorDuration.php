<?php

Breadcrumbs::for('dashboard.sponsorDurations.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('sponsorship.plural'), route('dashboard.sponsorDurations.index'));
});

Breadcrumbs::for('dashboard.sponsorDurations.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.sponsorDurations.index');
    $breadcrumb->push(trans('sponsorship.trashed'), route('dashboard.sponsorDurations.trashed'));
});

Breadcrumbs::for('dashboard.sponsorDurations.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.sponsorDurations.index');
    $breadcrumb->push(trans('sponsorship.actions.create'), route('dashboard.sponsorDurations.create'));
});
Breadcrumbs::for('dashboard.sponsorDurations.show', function ($breadcrumb, $sponsorDuration) {
    $breadcrumb->parent('dashboard.sponsorDurations.index');
    $breadcrumb->push($sponsorDuration->title, route('dashboard.sponsorDurations.show', $sponsorDuration));
});

Breadcrumbs::for('dashboard.sponsorDurations.edit', function ($breadcrumb, $sponsorDuration) {
    $breadcrumb->parent('dashboard.sponsorDurations.show', $sponsorDuration);
    $breadcrumb->push(trans('sponsorship.actions.edit'), route('dashboard.sponsorDurations.edit', $sponsorDuration));
});
