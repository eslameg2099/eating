<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Events\VerificationCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Firebase\Auth\Token\Exception\ExpiredToken;
use Firebase\Auth\Token\Verifier;
class VerificationController extends Controller
{
    use ValidatesRequests;

    /**
     * Send or resend the verification code.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
       
     
        $this->validate($request, [
            'token' => ['required'],
        ], [], trans('verification.attributes'));


        $tokenParts = explode(".", $request->token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        $phone = trim($jwtPayload->phone_number);
   
        $user =$user = User::where('id',auth()->user()->id)->firstOrFail(); 
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

    /**
     * Verify the user's phone number.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function verifyFb(Request $request)
    {
       
        $this->validate($request, [
            'phone' => 'required',
            'token' => 'required',
        ], [], trans('verification.attributes'));
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
    public function verify(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ], [], trans('verification.attributes'));

        $verification = Verification::where([
            'user_id' => auth()->id(),
            'code' => $request->code,
        ])->first();
        if (! $verification) {
            throw ValidationException::withMessages(['code' => [trans('verification.invalid')], ]);
        }
        if ($verification->isExpired()) {
            throw ValidationException::withMessages(['code' => [trans('verification.expired')], ]);
        }


        $verification->user->forceFill([
            'phone' => $verification->phone,
            'phone_verified_at' => now(),
        ])->save();

        $verification->delete();

        return $verification->user->getResource();
    }

    /**
     * check phone exist.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_phone(Request $request)
    {
        
        $this->validate($request, [
            'phone' => ['required', 'exists:users,phone'],
        ], [], trans('verification.attributes'));
        $user = User::where('phone', $request->phone)->firstOrFail();
        if (! $user) {
            return response()->json('unuthorized', 422);
        }

        $verification = Verification::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'phone' => $request->phone,
            'code' => rand(1111, 9999),
        ]);

        event(new VerificationCreated($verification));

        return response()->json([
            'message' => trans('verification.sent'),
        ]);
    }

    public function restore_account(Request $request)
    {
        $this->validate($request, [
            'code' => ['required', 'exists:verifications,code'],
            'phone' => ['required'],
            'password' => ['required'],
        ], [], trans('verification.attributes'));

        $verification = Verification::where([
            'code' => $request->code,
        ])->first();

        if (! $verification) {
            throw ValidationException::withMessages(['code' => [trans('verification.invalid')], ]);
        }
        if ($verification->isExpired()) {
            throw ValidationException::withMessages(['code' => [trans('verification.expired')], ]);
        }

        $user = User::where('phone', $request->phone)->firstOrFail();
        if (! $user) {
            return response()->json('Something Went Wrong', 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        event(new Login('sanctum', $user, false));

        return $user->refresh()->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
        ]);
    }

    /**
     * Check if the password of the authenticated user is correct.
     *
     * @param \Illuminate\Http\Request $request
     *@throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ], [], trans('auth.attributes'));


        if (! Hash::check($request->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [trans('auth.password')],
            ]);
        }

        return response()->json(['message'=> trans('auth.messages.true-pass')], 200);
    }

    public function checkphone(Request $request)
    {
       
        $request->validate([
            'phone' => 'required',
        ], [], trans('auth.attributes'));

        $phone = $request->phone;

        $user = User::where('phone','+'.$phone)->first();
   
        if ($user != null) {
            return response()->json(['message'=> 'هذا الهاتف موجود من قبل','check' => false],422);
        }

        else

            return response()->json(['message'=> 'هاتف غير مستخدم','check' => true],200);



    }

    public function checktype(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ], [], trans('auth.attributes'));

        $phone = $request->phone;

        $user = User::where('phone','+'.$phone)->first();
   
        if ($user != null) {
            return response()->json(['type' => $user->type],200);
        }

        else

        return response()->json(['message'=> 'هاتف غير مسجل من قبل'],422);



    }
}
