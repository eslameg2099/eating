<?php

return [
    'plural' => 'Chefs',
    'singular' => 'Chef',
    'empty' => 'There are no chefs',
    'select' => 'Select Chef',
    'permission' => 'Manage Chefs',
    'trashed' => 'Trashed Chefs',
    'perPage' => 'Count Results Per Page',
    'actions' => [
        'list' => 'List Chefs',
        'show' => 'Show Chef',
        'create' => 'Create',
        'new' => 'New',
        'edit' => 'Edit Chef',
        'delete' => 'Delete Chef',
        'restore' => 'Restore',
        'forceDelete' => 'Force Delete',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The chef has been created successfully.',
        'updated' => 'The chef has been updated successfully.',
        'deleted' => 'The chef has been deleted successfully.',
        'restored' => 'The chef has been restored successfully.',
    ],
    'attributes' => [
        'name' => 'Name',
        'phone' => 'Phone',
        'email' => 'Email',
        'created_at' => 'The Date Of Join',
        'old_password' => 'Old Password',
        'password' => 'Password',
        'password_confirmation' => 'Password Confirmation',
        'type' => 'User Type',
        'avatar' => 'Avatar',
        'permissions' => 'Permissions'

    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the chef ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the chef ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to force delete the chef ?',
            'confirm' => 'Force',
            'cancel' => 'Cancel',
        ],
    ],
];
