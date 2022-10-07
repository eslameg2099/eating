<?php

namespace App\Support\Payment\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HyperpayController
{
    public function __invoke()
    {
        $date = now()->toDateTimeString();

        $text = "*Hyperpay Notification* \n";

        $text .= "*Date:* $date \n";

        $text .= "*Body:* \n";

        $text .= "``` \n";

        $text .= json_encode(request()->all(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);

        $text .= "``` \n";

        Http::post(config('services.hyperpay.notification_slack_webhook_url'), compact('text'));
    }
}