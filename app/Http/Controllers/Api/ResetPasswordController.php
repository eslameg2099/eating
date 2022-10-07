<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MiniUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Firebase\Auth\Token\Exception\ExpiredToken;
use Firebase\Auth\Token\Verifier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ResetPasswordCode;
use Illuminate\Auth\Events\Login;
use App\Models\ResetPasswordToken;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\ResetPasswordCodeRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\Accounts\PasswordUpdatedNotification;
use App\Notifications\Accounts\SendForgetPasswordCodeNotification;
use App\Support\FirebaseToken;

class ResetPasswordController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    private $firebaseToken;


    /**
     * Send the forget password code to the user.
     *
     * @param \App\Http\Requests\Api\ForgetPasswordRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function forget_v2(ForgetPasswordRequest $request)
    {
        $project_id =   env('FirebaseProjectId','gasation2');
        $verifier = new Verifier($project_id);
        try {
            $verifiedIdToken = $verifier->verifyIdToken($request->input('token'));
            $phone = $verifiedIdToken->getClaim('phone_number');
            if($phone) {
                $phone = preg_replace('/^\+?966|\|966|\D/', '', ($phone));
                $user = User::query()->where('phone', $phone)->first();
                $user->update(['phone_verified_at' => Carbon::now()]);
                return response()->json([
                    'status' =>  true,
                    'message'    =>  trans('global.confirmed_success'),
                    'user'  =>  new MiniUserResource($user)
                ]);
            } else
            {
                return response()->json([
                    'status' =>  false,
                    'message'    =>  trans('global.invalid_phone_number')
                ], 422);
            }
        }catch (ExpiredToken $e) {
            return response()->json([
                'status' =>  false,
                'message'    =>  trans('global.invalid_token')
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' =>  false,
                'message'    =>  trans('global.invalid_phone_number'),
                'fireBaseMessage'   =>  $e->getMessage(),
            ], 422);
        }
    }
    public function forget(ForgetPasswordRequest $request)
    {
        $user = User::where(function (Builder $query) use ($request) {
            $query->where('phone', $request->phone);
        })->first();
        if (! $user) {
            throw ValidationException::withMessages([
                'phone' => [trans('auth.failed')],
            ]);
        }

        $resetPasswordCode = ResetPasswordCode::updateOrCreate([
            'phone' => $request->phone,
        ], [
            'phone' => $request->phone,
            'code' => rand(1000, 9999),
        ]);

        $user->notify(new SendForgetPasswordCodeNotification($resetPasswordCode->code));
        try {
            Storage::disk('public')->append(
                'verification.txt',
                "The reset password code for user phone {$request->phone} is {$resetPasswordCode->code} generated at ".now()->toDateTimeString()."\n"
            );
        } catch (\Exception $exception) {
        }

        if (app()->environment('local')) {
            Storage::disk('public')->append(
                'verification.txt',
                "The reset password code for user phone {$request->phone} is {$resetPasswordCode->code} generated at ".now()->toDateTimeString()."\n"
            );
        }

        return response()->json([
            'message' => trans('auth.messages.forget-password-code-sent'),
            'links' => [
                'code' => [
                    'href' => route('api.password.code'),
                    'method' => 'POST',
                ],
            ],
        ]);
    }

    /**
     * Get the reset password token using verification code.
     *
     * @param \App\Http\Requests\Api\ResetPasswordCodeRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function code(ResetPasswordCodeRequest $request)
    {

        $tokenParts = explode(".", $request->token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        $phone = trim($jwtPayload->phone_number);
      // return $jwtPayload->phone_number;
   $user = User::query()->where('phone', $jwtPayload->phone_number)->first();
    if($user == null)
       {
        throw ValidationException::withMessages([
            'phone' => [trans('auth.failed')],
        ]);
       }
       else
        $user->forceFill([
            'phone' => $phone,
            'phone_verified_at' => now(),
            'password' => Hash::make($request->password),
        ])->save();
        
        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
        ]);

    }

    public function reset(ResetPasswordCodeRequest $request)
    {
        $tokenParts = explode(".", $request->token);
     
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        $phone = trim($jwtPayload->phone_number);
        
        if ($phone != $request->phone) throw ValidationException::withMessages(['code' => [trans('verification.invalid')], ]);
        if (! $user = auth()->user()) $user = User::where('phone',$request->phone)->firstOrFail();
        $user->forceFill([
            'phone' => $phone,
            'phone_verified_at' => now(),
        ])->save();
        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
        ]);
      

    }
}
