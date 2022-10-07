<?php
return [
    'plural' => 'Notifications',
    'plural-certain' => 'Special Notifications ',
    'admin_notification' => 'Administration Notification',
    'attributes' => [
        'user_type' => 'Choose Membership',
        'title' => 'Title',
        'body' => 'Body',
        'notification_type' => 'Notification Type',
        'user_id' => 'User id'
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
        "vote" => 'New Vote',
        "receive_order" => 'Your Order Has Delivered',
        "cancel_order" => 'Order Has Canceled',
        "end-specialOrder" => 'Your Special Order Has Finished',
        "kitchen_activated" => 'Administration has Activated Your Kitchen',
        "review" => 'A New Review',
        "order" => 'You have a new order.',
        "order-accepted" => 'Your Order Has been Accepted',
        "specialOrder" => 'You have a new Special Order',
        "new_message" => 'You have a new message from :sender',
    ],
    "messages" => [
        "receive_order" => ':user has received your Meals, Order number :order_id.',
        "approve-specialOrder" => ':user has accept your Offer.',
        "end-specialOrder" => ':user has end your special order , order number :order_id .',
        "activation" => 'Administration has Activated your :kitchen Kitchen',
        'sent' => 'Sent Successfully',
        "favorite" => 'Your Kitchen Has Added To Favorite',
        "order" => ':user has creat a new order from your kitchen',
        "order-cancel" => ':chef has Canceled the order, number :order_id',
        "vote" => 'Your Kitchen has been voted',
        "order-accepted" => ':chef has been Accepted your Order, Please Pay or Confirm.',
        "specialOrder" => ':user has create a special order from your Kitchen',
        "new_message_body" => ':message'
    ]
];
