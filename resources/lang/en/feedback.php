<?php

return [
    'singular' => 'Feedback',
    'plural' => 'Feedback',
    'empty' => 'There are no feedback yet.',
    'count' => 'Feedback Count.',
    'search' => 'Search',
    'select' => 'Select Feedback',
    'permission' => 'Manage Feedback',
    'trashed' => 'Trashed Feedback',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for feedback',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new feedback',
        'show' => 'Show feedback',
        'edit' => 'Edit feedback',
        'delete' => 'Delete feedback',
        'restore' => 'Restore',
        'forceDelete' => 'Force Delete',
        'read' => 'Mark As Read',
        'unread' => 'Mark As Unread',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'sent' => 'The feedback has been sent successfully.',
        'deleted' => 'The feedback has been deleted successfully.',
        'restored' => 'The feedback has been restored successfully.',
    ],
    'attributes' => [
        'name' => 'Name',
        'phone' => 'Phone',
        'email' => 'Email',
        'title' => 'Title',
        'message' => 'Message',
        'read_at' => 'Read at',
        'read' => 'Read',
        'unread' => 'Unread',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the feedback?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the feedback ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to force delete the feedback ?',
            'confirm' => 'Force',
            'cancel' => 'Cancel',
        ],
    ],
];
