<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\Chef;

use App\Notifications\Channels\PusherChannel;
use App\Models\Notification as NotificationModel;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;



class SendBeforeten extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-beforeten';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::where("status",Order::COOKING_STATUS)
        ->where("cooked_at",'>=', Carbon::now()->subMinutes(10)->toDateTimeString())->get();
    foreach ($orders as $order){
        $user = Chef::find($order->chef_id);
            Notification::send($user, new CustomNotification([
                'via' => ['database', PusherChannel::class],
                'database' => [
                    'trans' => 'new order near',
                    'type' => NotificationModel::Beforeten_TYPE,
                    'order_id' => $order->id ,
                    'user_id' => $user->id ,

                ],
                'fcm' => [
                    'title' => 'اقترب وقت التحضير',
                    'body' =>'باقي من الزمن 10 دقائق' ,
                    'type' => NotificationModel::Beforeten_TYPE,
                    'data' => [
                        'id' => $order->id ,
                    ],
                ],
            ]));
       
    }
     return 0;

    }
}
