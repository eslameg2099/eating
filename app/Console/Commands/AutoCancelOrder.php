<?php

namespace App\Console\Commands;

use App\Models\CanceledOrder;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCancelOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-cancel';

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
        $orders = Order::whereIn("status",[Order::REQUEST_STATUS , Order::PENDING_STATUS])
            ->where("updated_at",'>=', Carbon::now()->subMinutes(10)->toDateTimeString())->get();
        foreach ($orders as $order){
            CanceledOrder::create([
                "order_id" => $order->id,
                "type" => 'auto'
            ]);
            $order->update([
                'status' => Order::AUTO_CANCEL
            ]);
            $order->delete();
            $this->info("Order #{$order->id} has been canceled.");
        }
        return 0;
    }
}
