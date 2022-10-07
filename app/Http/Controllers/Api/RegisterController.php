<?php

namespace App\Http\Controllers\Api;

use App\Models\Chef;
use App\Models\User;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\Verification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Events\VerificationCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RegisterController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function register(RegisterRequest $request)
    {
        switch ($request->type) {
            case User::CHEF_TYPE:
                $user = $this->createChef($request);
                break;
            case User::DELEGATE_TYPE:
                $user = $this->createDelegate($request);
                break;
            default:
                $user = $this->createCustomer($request);
                break;
        }

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->usingFileName(time().'.png')
                ->toMediaCollection('avatars');
        }

        event(new Registered($user));

        $this->sendVerificationCode($user);

        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
            'message' => trans('verification.sent'),
        ]);
    }

    /**
     * Create new customer , Chef and Admin to register to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return Delegate
     */
    public function createDelegate(RegisterRequest $request)
    {
        $delegate = new Delegate();

        $delegate
            ->forceFill($request->only('phone', 'type'))
            ->fill($request->allWithHashedPassword())
            ->save();
        $delegate->uploadFile('identity_front_image', 'identity_front_image');
        $delegate->uploadFile('identity_back_image', 'identity_back_image');

        return $delegate;
    }

    /**
     * Create new customer , Chef and Admin to register to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return \App\Models\Customer
     */
    public function createCustomer(RegisterRequest $request)
    {
        $customer = new Customer();

        $customer
            ->forceFill($request->only('phone', 'type'))
            ->fill($request->allWithHashedPassword())
            ->save();
        $customer->fastDeposit($customer,0);
        return $customer;
    }

    public function createChef(RegisterRequest $request)
    {
        $chef = new Chef();

        $chef
            ->forceFill($request->only('phone', 'type'))
            ->fill($request->allWithHashedPassword())
            ->save();
        $chef->fastDeposit($chef,0);

        return $chef;
    }

    public function createAdmin(RegisterRequest $request)
    {
        $admin = new Admin();

        $admin
            ->forceFill($request->only('phone', 'type'))
            ->fill($request->allWithHashedPassword())
            ->save();

        return $admin;
    }

    /**
     * Send the phone number verification code.
     *
     * @param \App\Models\User $user
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    protected function sendVerificationCode(User $user): void
    {
        if (! $user || $user->phone_verified_at) {
            throw ValidationException::withMessages([
                'phone' => [trans('verification.verified')],
            ]);
        }

        $verification = Verification::updateOrCreate([
            'user_id' => $user->id,
            'phone' => $user->phone,
        ], [
            'code' => rand(1111, 9999),
        ]);

        event(new VerificationCreated($verification));
    }
}
