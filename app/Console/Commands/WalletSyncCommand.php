<?php

namespace App\Console\Commands;

use App\Support\Payment\Models\Checkout;
use App\Support\Payment\Models\Transaction;
use Illuminate\Console\Command;

/**
 * @Deprecated
 */
class WalletSyncCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the pending transactions and update status.';

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
        Checkout::pending()->each(function (Checkout $checkout) {
            Cashier::setCheckout($checkout)->updateStatus();

            $checkout->refresh();

            $status = Transaction::PENDING_STATUS;

            if ($checkout->isPending()) {
                $status = Transaction::PENDING_STATUS;
            }
            if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
                $status = Transaction::TRANSFER_STATUS;
            }
            if ($checkout->isRejected() || $checkout->isRejectedByExternalBank()) {
                $status = Transaction::REJECTED_STATUS;
            }

            $checkout->transactions()->update(compact('status'));
        });

        return 0;
    }
}
