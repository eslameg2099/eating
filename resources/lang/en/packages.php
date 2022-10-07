<?php

return [
    'singular' => 'Package',
    'plural' => 'Packages',
    'empty' => 'There are no packages yet.',
    'count' => 'Packages Count.',
    'search' => 'Search',
    'select' => 'Select Package',
    'permission' => 'Manage packages',
    'trashed' => 'Trashed packages',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for package',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new package',
        'show' => 'Show package',
        'edit' => 'Edit package',
        'delete' => 'Delete package',
        'restore' => 'Restore',
        'forceDelete' => 'Delete Forever',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The package has been created successfully.',
        'updated' => 'The package has been updated successfully.',
        'deleted' => 'The package has been deleted successfully.',
        'restored' => 'The package has been restored successfully.',
    ],
    'attributes' => [
        'name' => 'Package name',
        'from_kg' => 'Start Count per km',
        'to_kg' => 'End Count per Km',
        'cost' => 'Cost',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the package ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the package ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the package forever ?',
            'confirm' => 'Delete Forever',
            'cancel' => 'Cancel',
        ],
    ],
];
