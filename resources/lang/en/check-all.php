<?php

return [
    'actions' => [
        'delete' => 'Delete Selected',
        'reject' => 'reject Selected',
    ],
    'messages' => [
        'deleted' => 'The :type has been selected successfully.',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the :type ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'reject' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to reject the :type ?',
            'confirm' => 'reject',
            'cancel' => 'Cancel',
        ],
    ],
];
