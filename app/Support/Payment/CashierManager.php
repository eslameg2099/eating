<?php

namespace App\Support\Payment;

use App\Models\User;
use App\Models\Order;
use App\Support\Payment\Models\Checkout;
use App\Support\Payment\Models\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CashierManager
{
    /**
     * @var \Illuminate\Http\Client\PendingRequest
     */
    protected $http;

    /**
     * @var string
     */
    protected $hyperpay_base_url;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * @var \App\Models\User
     */
    protected $actor;

    /**
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * @var \App\Support\Payment\Models\Checkout
     */
    protected $checkout;

    /**
     * Create the cashier manager instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->http = Http::withToken(
            config('services.hyperpay.access_token')
        );

        if (config('services.hyperpay.mode') == 'test') {
            $this->hyperpay_base_url = 'https://test.oppwa.com/v1';
        } else {
            $this->hyperpay_base_url = 'https://oppwa.com/v1';
        }
    }

    /**
     * @param \App\Models\User $user
     * @return CashierManager
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param \App\Models\User $actor
     * @return CashierManager
     */
    public function setActor(User $actor)
    {
        $this->actor = $actor;
        return $this;
    }

    /**
     * @param \App\Models\Order $order
     * @return CashierManager
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param \App\Support\Payment\Models\Checkout|string $checkout
     * @throws \Exception
     * @return CashierManager
     */
    public function setCheckout($checkout)
    {
        if ($checkout instanceof Checkout) {
            $model = $checkout;
        } else {
            $model = Checkout::query()
                ->where('checkout_id', $checkout)
                ->first();
        }
        if (! $model) {
            throw new \Exception('Checkout Not Found');
        }

        $this->checkout = $model;
        $this->setUser($model->user);

        return $this;
    }

    /**
     * @return \App\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \App\Support\Payment\Models\Checkout
     */
    public function getCheckout()
    {
        return $this->checkout;
    }

    /**
     * @return \App\Models\User
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @return \App\Models\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function bill(string $checkoutId = null)
    {
        $this->setUser(User::first());
        if (! $this->getOrder()) {
            throw new \Exception('Order Not Found: please set the order using "setOrder()" method before bill');
        }

        if ($this->getOrder()->payment_type == Order::ONLINE_PAYMENT) {
            $response = $this->http
                ->asForm()
                ->post($this->url('checkouts'), [
                    'entityId' => config('services.hyperpay.payment_methods.visa.entity_id'),
                    'amount' => '92.00',
                    'currency' => config('services.hyperpay.currency'),
                    'paymentType' => config('services.hyperpay.payment_methods.visa.type'),
                    'notificationUrl' => route('hyperpay.notify'),
                ]);
        }
    }

    public function prepareCheckout($amount, $paymentType = 'visa')
    {
        $identifier = Str::random(40);

        $user = $this->getUser() ?: auth()->user();

        if (! $user) {
            throw new \Exception('User Not Found: please set the user using "setUser()" method before prepare checkout');
        }

        $data = [
            'testMode' => 'EXTERNAL',
            'entityId' => config("services.hyperpay.payment_methods.$paymentType.entity_id"),
            'amount' => number_format($amount, 2, '.', ''),
            'currency' => config('services.hyperpay.currency'),
            'paymentType' => config("services.hyperpay.payment_methods.$paymentType.type"),
            'notificationUrl' => route('hyperpay.notify'),
            'customParameters' => ['user_id' => $user->id],
            'customer.merchantCustomerId' => $user->id,
            'customer.email' => $user->email,
            'customer.givenName' => $user->name,
            'customer.surname' => $user->name,
            'merchantTransactionId' => $identifier,
            'billing.street1' => 'Test',
            'billing.city' => 'City',
            'billing.state' => 'State',
            'billing.country' => 'SA',
            'billing.postcode' => '21500',
        ];

        if (config('services.hyperpay.mode') == 'test') {
            //$data['testMode'] = 'EXTERNAL';
        }
        $response = $this->http->asForm()->post($this->url('checkouts'), $data);

        return Checkout::create([
            'user_id' => $user->id,
            'checkout_id' => $response->json('id'),
            'transaction_identifier' => $identifier,
            'amount' => $amount,
            'payment_type' => $paymentType,
            'status' => $response->json('result.code'),
        ]);
    }

    /**
     * @throws \Exception
     * @return $this
     */
    public function updateStatus()
    {
        $this->getCheckout()->update([
            'status' => $this->getFreshResultCode(),
        ]);

        return $this;
    }

    /**
     * Get the fresh result code from hyper pay.
     *
     * @throws \Exception
     * @return string
     */
    public function getFreshResultCode()
    {
        $checkout = $this->getCheckout();

        if (! $checkout) {
            throw new \Exception('Checkout Not Found: please set the checkout using "setCheckout()" method.');
        }

        $data = [
            'entityId' => config("services.hyperpay.payment_methods.{$checkout->payment_type}.entity_id"),
        ];

        $response = $this->http->get($this->url("checkouts/{$checkout->checkout_id}/payment"), $data);
        //dd($this->url("checkouts/{$checkout->checkout_id}/payment"), $data, $response->json());
        return $response->json('result.code');
    }


    /**
     * Get the fresh result code from hyper pay.
     *
     * @throws \Exception
     * @return array
     */
    public function getResultCode($paymentType, $checkout)
    {
        $data = [
            'entityId' => config("services.hyperpay.payment_methods.{$paymentType}.entity_id"),
        ];

        $response = $this->http->get($this->url("checkouts/{$checkout}/payment"), $data);
        //dd($this->url("checkouts/{$checkout->checkout_id}/payment"), $data, $response->json());

        return [
            'request' => [
                'url' => $this->url("checkouts/{$checkout}/payment"),
                'data' => $data,
            ],
            'response' => $response->json(),
        ];
    }

    public function getStatus()
    {
        $checkout = $this->getCheckout();

        if (! $checkout) {
            throw new \Exception('Checkout Not Found: please set the checkout using "setCheckout()" method.');
        }

        $data = [
            'entityId' => config("services.hyperpay.payment_methods.{$checkout->payment_type}.entity_id"),
        ];

        $response = $this->http->get($this->url("checkouts/{$checkout->checkout_id}/payment"), $data);

        return $response->json();
    }

    /**
     * @param $endpoint
     * @return string
     */
    protected function url($endpoint)
    {
        return trim($this->hyperpay_base_url, '/').'/'.$endpoint;
    }
}
