<?php

return [
    'plural' => 'المحافظ',
    'Admin' => 'محفظة النظام',
    'withdrawalRequests' => 'طلبات السحب',
    'excel' => 'إستخراج ملف اكسيل',
    'plural_customers' => 'محافظ العملاء',
    'plural_chefs' => 'محافظ الظهاة',
    'singular' => 'المحفظة',
    'empty' => 'لا توجد محافظ',
    'select' => 'اختر المحفظة',
    'permission' => 'ادارة المحافظ',
    'trashed' => 'المحافظ المحذوفين',
    'perPage' => 'عدد النتائج في الصفحة',
    'transaction' => 'قيمة التحويل مطلوبة',
    'currency' => 'ريال',
    'deposit' => 'إيداع',
    'withdrew' => 'سحب',
    'submit' => 'إرسال',
    'attributes' => [
      'id' => 'تسلسل العملية',
      'user_id' => 'تسلسل العميل',
      'user_name' => 'الإسم',
      'phone' => 'الجوال',
      'balance' => 'الرصيد',
      'total_charge' => 'اجمالي الشحن',
      'pending' => 'الرصيد المعلق',
      'transaction_count' => 'عدد مرات المعاملات',
        //
        'title'=> 'نوع المعاملة',
        'transaction' => 'المبلغ',
        'status' => 'الحالة',
        'confirmed' => 'حالة القبول',
        'created_at' => 'تاريخ الإنشاء',
        'creditData' => 'بيانات البطاقة',
        'note' => 'الملاحظة',
      'operations' => 'العمليات',
        'credit' => [
            'account-name' => 'اسم حامل البطاقة',
            'bank_name' => 'اسم البنك',
            'account_number' => 'رقم الحساب',
            'iban_number' => 'رقم الأيبان'
        ]

    ],
    'messages' => [
        'deposit' => 'تم الإيداع بنجاح.',
        'withdrew' => 'تم السحب بنجاح.',
        'transfer' => 'تم نقل المبلغ بنجاح.',
        'can_withdrew' => 'عفوا, رصيد المحفظة لا يكفي لإتمام العملية.',
        'cannot_withdrew' => 'عفوا لا يمكنك السحب من المحفظة, برجاء التواصل مع خدمة العملاء.',
        'can_transfer' => 'عفوا, رصيدك لا يكفي لإتمام العملية.',
        'transaction' => 'تمت العملية بنجاح, بمبلغ ',
        'withdrawals' => 'تمت عمليات السحب بنجاح ',
        'transaction-error' => 'حدث خطأ بالتحويل برجاء التواصل مع الإدارة ',
        'dialog_message' => 'تم تقديم طلب سحب رصيد من المحفظة\n وسيتم إيداع المبلغ في الحساب\n خلال 5 ايام عمل'
    ],
    'actions' => [
        'list' => 'كل المحافظ',
        'show' => 'عرض',
        'create' => 'إضافة',
        'new' => 'إضافة',
        'edit' => 'تعديل  المحفظ',
        'delete' => 'حذف المحفظ',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا المحفظة ؟',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد استعادة هذا المحفظة ؟',
            'confirm' => 'استعادة',
            'cancel' => 'إلغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا المحفظة نهائياً؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'إلغاء',
        ],
    ],
    'statuses' => [
        '0' => 'غير معرف',
        \App\Support\Payment\Contracts\TransactionStatuses::CHARGE_WALLET_STATUS => 'شحن محفظة' ,
        \App\Support\Payment\Contracts\TransactionStatuses::PENDING_STATUS => 'معلق' ,
        \App\Support\Payment\Contracts\TransactionStatuses::HOLED_STATUS => '' ,
        \App\Support\Payment\Contracts\TransactionStatuses::REJECTED_STATUS => 'مرفوض' ,
        \App\Support\Payment\Contracts\TransactionStatuses::WITHDRAWAL_STATUS => 'طلب سحب' ,
        \App\Support\Payment\Contracts\TransactionStatuses::TRANSFER_STATUS => 'نقل اموال' ,
        \App\Support\Payment\Contracts\TransactionStatuses::SPONSOR_STATUS => 'طلب تمويل' ,
    ],
    'titles' => [
        'deposit' => 'إيداع',
        'withdrew' => 'سحب'
    ],
    'excel-header' =>
    [
        '#',
        'اسم المستخدم',
        'اسم صاحب البطاقة',
        'اسم الحساب',
        'رقم الحساب',
        'رقم الأيبان',
        'قيمة المبلغ',
    ]
];
