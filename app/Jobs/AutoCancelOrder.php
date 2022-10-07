<?php

namespace App\Jobs;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoCancelOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order = null;
    protected $orderRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->orderRepository =new OrderRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(Carbon::now()->gte(Carbon::Parse($this->order->updated_at)->addMinutes(1))) $this->orderRepository->autoCancel($this->order) ;
    }
}
