<?php

return [
    'singular' => 'الاقسام',
    'plural' => 'اقسام ',
    'empty' => 'لا يوجد اقسام حتى الان',
    'count' => 'عدد اقسام اتصل بنا',
    'search' => 'بحث',
    'select' => 'اختر الاقسام',
    'permission' => 'ادارة اقسام ',
    'trashed' => 'الاقسام المحذوفة',
    'perPage' => 'عدد النتائج بالصفحة',
    'filter' => 'ابحث عن قسم',
    'actions' => [
        'list' => 'عرض الكل',
        'create' => 'اضافة قسم',
        'show' => 'عرض الاقسام',
        'edit' => 'تعديل الاقسام',
        'delete' => 'حذف الاقسام',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'messages' => [
        'sent' => 'تم ارسال الاقسام بنجاح.',
        'deleted' => 'تم حذف الاقسام بنجاح.',
        'restored' => 'تم استعادة الاقسام بنجاح .',
    ],
    'attributes' => [
        'title' => 'title',
        'active' => 'active',
        'created_at' => 'created_at',
        'deleted_at' => 'تاريخ الإيقاف',
        'image' => 'image'
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد حذف الاقسام',
            'confirm' => 'حذف',
            'cancel' => 'الغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد استعادة الاقسام ؟',
            'confirm' => 'استعادة',
            'cancel' => 'إلغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف الاقسام نهائياً؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'إلغاء',
        ],
    ],
];
