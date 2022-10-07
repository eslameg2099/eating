<?php

return [
    'plural' => 'المطابخ',
    'singular' => 'المطبخ',
    'empty' => 'لا توجد مطابخ',
    'select' => 'اختر المطبخ',
    'permission' => 'ادارة المطابخ',
    'trashed' => 'المطابخ المحذوفة',
    'perPage' => 'عدد النتائج في الصفحة',
    'requests' => 'طلبات تسجيل مطبخ',
    'actions' => [
        'list' => 'كل المطابخ',
        'show' => 'عرض',
        'create' => 'إضافة',
        'new' => 'إضافة',
        'edit' => 'تعديل  المطبخ',
        'delete' => 'حذف المطبخ',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'messages' => [
        'created' => 'تم إضافة المطبخ بنجاح .',
        'updated' => 'تم تعديل المطبخ بنجاح .',
        'deleted' => 'تم حذف المطبخ بنجاح .',
        'restored' => 'تم استعادة المطبخ بنجاح .',
        'accept' => 'تم قبول المطبخ بنجاح .',
        'not-found' => 'لم يتم العثور علي المطبخ.',
        'not-active' => 'المطبخ ليس نشط حاليا لإستقبال الطلبات.',
    ],
    'attributes' => [
        'kitchen_id' => 'تسلسل المطبخ',
        'user_id' => 'رقم عضوية الطاهي',
        'name' => 'اسم المطبخ',
        'chef' => 'اسم الطاهي',
        'description' => 'وصف المطبخ',
        'address' => 'عنوان المطبخ',
        'city_id' => 'المدينة',
        'longitude' => 'خط الطول',
        'latitude' => 'خط العرض',
        "activation" => 'مفعل',
        "receive-orders"=> 'طلبات',
        "receive-special"=> 'طلبات خاصة',
        "rate"=> 'التقييم',
        "operations"=> 'العمليات',
        'default' => 'صورة المطبخ',
        'evidence' => 'الوثيقة',
        'city' => 'المدينة',
        'cookable_type' => 'النوع',
        'deleted' => 'موقوف',
'map_addres'=>'عنوان الخريطة',

    ],
    'name' => 'اسم المطبخ مطلوب',
    '%name%' => 'اسم المطبخ مطلوب',
    'description' => 'وصف المطبخ مطلوب',
    '%description%' => 'وصف المطبخ مطلوب',
    'address' => 'عنوان المطبخ مطلوب',
    '%address%' => 'عنوان المطبخ مطلوب',
    'types' => [
        'kitchen' => 'مطبخ',
        'foodtruck' => 'عربة طعام'
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا المطبخ ؟',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد استعادة هذا المطبخ ؟',
            'confirm' => 'استعادة',
            'cancel' => 'إلغاء',
        ],
        'accept' => [
            'title' => 'نبيه !',
            'info' => 'هل أنت متأكد انك تريد قبول هذا المطبخ ؟',
            'confirm' => 'قبول',
            'cancel' => 'إلغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا المطبخ نهائياً؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'إلغاء',
        ],
    ],

];