<?php

return [
    'singular' => 'Coupon',
    'plural' => 'Coupons',
    'empty' => 'There are no coupons yet.',
    'count' => 'Coupons Count.',
    'search' => 'Search',
    'select' => 'Select Coupon',
    'permission' => 'Manage coupons',
    'trashed' => 'Trashed coupons',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for coupon',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new coupon',
        'show' => 'Show coupon',
        'edit' => 'Edit coupon',
        'delete' => 'Delete coupon',
        'restore' => 'Restore',
        'forceDelete' => 'Delete Forever',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The coupon has been created successfully.',
        'updated' => 'The coupon has been updated successfully.',
        'deleted' => 'The coupon has been deleted successfully.',
        'restored' => 'The coupon has been restored successfully.',
    ],
    'attributes' => [
        'name' => 'Coupon name',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the coupon ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the coupon ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the coupon forever ?',
            'confirm' => 'Delete Forever',
            'cancel' => 'Cancel',
        ],
    ],
];
