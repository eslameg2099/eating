<?php

return [
    'actions' => [
        'delete' => 'حذف المحدد',
        'reject' => 'رفض المحدد',
        'restore' => 'استعادة المحدد',
        'accept' => 'قبول المحدد',
    ],
    'messages' => [
        'deleted' => 'تم حذف :type بنجاح.',
        'reject' => 'تم رفض :type بنجاح.',
        'accept' => 'تم قبول :type بنجاح.',
        'restored' => 'تم استعادة :type بنجاح.',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف :type',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
        'reject' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد رفض :type',
            'confirm' => 'رفض',
            'cancel' => 'إلغاء',
        ],
        'accept' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد قبول :type',
            'confirm' => 'قبول',
            'cancel' => 'إلغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد استعادة :type',
            'confirm' => 'استعادة',
            'cancel' => 'إلغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف :type نهائياً',
            'confirm' => 'حذف نهائي',
            'cancel' => 'إلغاء',
        ],
    ],
];
