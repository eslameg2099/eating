<?php

return [
    'singular' => 'Order',
    'plural' => 'Orders',
    'empty' => 'There are no orders yet.',
    'count' => 'Orders Count.',
    'search' => 'Search',
    'select' => 'Select Order',
    'permission' => 'Manage orders',
    'trashed' => 'Trashed orders',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for order',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new order',
        'show' => 'Show order',
        'edit' => 'Edit order',
        'delete' => 'Delete order',
        'restore' => 'Restore',
        'forceDelete' => 'Delete Forever',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The order has been created successfully.',
        'updated' => 'The order has been updated successfully.',
        'acceptOrder' => 'The order has been accepted successfully.',
        'workingOrder' => 'The order in working state.',
        'orderPrepared' => 'The order has been cooked.',
        'orderReceived' => 'The order is being delivered.',
        'orderDelivered' => 'Order Received (Finished)',
        'deleted' => 'The order has been deleted successfully.',
        'restored' => 'The order has been restored successfully.',
        'WrongStatement' => 'Something Wrong in Order State.',
        'unfinished_order' => 'You still have a pending Order.'
    ],
    'attributes' => [
        'meals' => 'Meals',
        'meals.*.id' => 'meal',
        'meals.*.quantity' => 'Quantity',
        'meals.*.size.size' => 'Size',
        'meals.*.color.name' => 'Color Name',
        'meals.*.color.hex' => 'Color Hex',
        'address_id' => 'Address',
        'status' => 'Status',
        'total_cost' => 'Sub Total',
        'discount' => 'Discount',
        'shipping_cost' => 'Shipping Cost',
        'user_id' => 'User',
        'purchased' => 'Paid',
        'shop_orders_count' => 'Shipments Count',
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
        \App\Models\Order::ONLINE_PAYMENT => 'Visa',
        \App\Models\Order::CASH_PAYMENT => 'Upon receipt',
        \App\Models\Order::WALLET_PAYMENT => 'Upon wallet',
    ],
];
