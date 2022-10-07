<?php

return [
    'singular' => 'الوجبة',
    'plural' => 'الوجبات',
    'empty' => 'لا يوجد طلبات حتى الان',
    'count' => 'عدد الطلبات',
    'search' => 'بحث',
    'select' => 'اختر الوجبة',
    'permission' => 'ادارة الطلبات',
    'trashed' => 'الطلبات المحذوفة',
    'perPage' => 'عدد النتائج بالصفحة',
    'filter' => 'ابحث عن طلب',
    'actions' => [
        'list' => 'عرض الكل',
        'create' => 'اضافة طلب',
        'show' => 'عرض الطلب',
        'edit' => 'تعديل الطلب',
        'delete' => 'حذف الطلب',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'options' => 'خيارات',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'messages' => [
        'created' => 'new request.',
        'updated' => 'تم تعديل الطلب بنجاح.',
        'initialAccept' => 'تم تحديد السعر والموعد.',
        'workingOrder' => 'The Order in Cooking State.',
        'deleted' => 'تم حذف الطلب بنجاح.',
        'restored' => 'تم استعادة الطلب بنجاح.',
        'accepted' => 'accepted request from chef , cost and time have been set',
        'finished' => 'The Special Order has Finished.',
        'userCancel' => 'The Special Order has Canceled from the User.',
        'chefCancel' => 'The Special Order has Canceled from the Chef.',
        'approved' => 'approved cost and time from customer.',
        'cannotCancel' => 'You cannot Decline The Special Order During this status.',
    ],
    'attributes' => [
        'meals' => 'الوجبات',
        'meals.*.id' => 'الوجبة',
        'meals.*.quantity' => 'الكمية',
        'address' => 'العنوان',
        'status' => 'الحالة',
        'total_cost' => 'اجمالي التكلفة',
        'discount' => 'مقدار الخصم',
        'shipping_cost' => 'تكلفة التوصيل',
        'user_id' => 'المستخدم',
        'purchased' => 'تم الدفع',
    ],
    'statuses' => [
        \App\Models\Order::REQUEST_STATUS => 'جديد',
        \App\Models\Order::PENDING_STATUS => 'تمت الموافقة علي الطلب',
        \App\Models\Order::COOKING_STATUS => 'جاري التجهيز',
        \App\Models\Order::COOKED_STATUS => 'بإنتظار المندوب',
        \App\Models\Order::RECEIVED_STATUS => 'جاري التوصيل',
        \App\Models\Order::DELIVERED_STATUS => 'تم إستلام الطلب',
    ],
    'payments' => [
        \App\Models\Order::ONLINE_PAYMENT => 'بطاقة الإئتمان',
        \App\Models\Order::CASH_PAYMENT => 'دفع عند الاستلام',
        \App\Models\Order::WALLET_PAYMENT => 'دفع من رصيد المحفظة',
    ],
];
