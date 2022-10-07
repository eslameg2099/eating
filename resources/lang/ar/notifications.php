<?php
return [
    'plural' => 'الإشعارات',
    'plural-certain' => 'الإشعارات المخصصة',
    'admin_notification' => 'إشعار من الإدارة',
    'attributes' => [
        'user_type' => 'حدد العضوية',
        'title' => 'عنوان الإشعار',
        'body' => 'نص الإشعار',
        'notification_type' => 'نوع الإشعار',
        'user_id' => 'عضوية المستخدم'
    ],
    'form' => [
      'user_type' => [
          \App\Models\User::CUSTOMER_TYPE => 'عملاء',
          \App\Models\User::CHEF_TYPE => 'طهاة',
      ],
      'notification_type' => [
          '1' => 'عام',
          '2' => 'مخصص',
      ],

    ],
    'actions' => [
        'create' => 'إرسال إشعار',
        'save' => 'إرسال',
        'certain' => 'إشعار محدد',
        'back' => 'رجوع للإشعارات العامة',
    ],
    "titles" => [
        "vote" => 'لديك تقييم جديد',
        "order" => 'لديك طلب جديد',
        "receive_order" => 'تم توصيل الطلب',
        "cancel_order" => 'تم إلغاء الطلب',
        "order-accepted" => 'تمت الموافقة علي طلبك',
        "specialOrder" => 'لديك طلب خاص جديد',
        "end-specialOrder" => 'تم إنهاء الطلب الخاص',
        "new_message" => 'لديك رسالة جديدة من :sender',
        "kitchen_activated" => 'قامت الإدارة بتفعيل مطبخك',
    ],
    "messages" => [
        "favorite" => 'قام بضم مطبخك إلي المفضلة.',
        "order" => 'قام :user بطلب اوردر من مطبخك',
        "order-accepted" => 'قام :chef بالموافقة على طلبك , برجاء الدفع او التأكيد',
        "order-cancel" => 'قام :user بإلغاء الطلب رقم :order_id',
        "receive_order" => 'قام :user بإستلام الطلب رقم :order_id',
        "specialOrder" => 'قام :user بطلب خاص من مطبخك',
        "approve-specialOrder" => 'قام :user بقبول عرضك الخاص .',
        "end-specialOrder" => 'قام :user بإنهاء الطلب الخاص رقم :order_id .',
        "vote" => 'قام احدهم بعمل تقييم .',
        "new_message_body" => ':message',
        "activation" => ':kitchen قامت الإدارة بتفعيل مطبخ ',
        'sent' => 'تم الإرسال بنجاح'
    ]
];
