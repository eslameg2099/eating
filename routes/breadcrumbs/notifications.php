<?php

Breadcrumbs::for('dashboard.notifications.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('notifications.plural'), route('dashboard.notifications.index'));
});

Breadcrumbs::for('dashboard.notifications.certain', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.notifications.index');
    $breadcrumb->push(trans('notifications.plural-certain'), route('dashboard.notifications.certain'));
});
//Breadcrumbs::for('dashboard.notifications.show', function ($breadcrumb, $sponsorDuration) {
//    $breadcrumb->parent('dashboard.notifications.index');
//    $breadcrumb->push($sponsorDuration->title, route('dashboard.notifications.show', $sponsorDuration));
//});
//
//Breadcrumbs::for('dashboard.notifications.edit', function ($breadcrumb, $sponsorDuration) {
//    $breadcrumb->parent('dashboard.notifications.show', $sponsorDuration);
//    $breadcrumb->push(trans('notifications.actions.edit'), route('dashboard.notifications.edit', $sponsorDuration));
//});
