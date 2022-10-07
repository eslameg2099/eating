<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\ProfileRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\Accounts\PasswordUpdatedNotification;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display the authenticated user resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show()
    {
        return auth()->user()->getResource();
    }

    /**
     * Update the authenticated user profile.
     *
     * @param \App\Http\Requests\Api\ProfileRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->allWithHashedPassword());

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->usingFileName(time().'.png')
                ->toMediaCollection('avatars');
        }

        return $user->refresh()->getResource();
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        if (! $user) {
            return response()->json('unauthenticated', 401);
        }
//        if(Hash::check($request->new_password,$user->password)) return response()->json(trans("auth.messages.change-same-password"),422);

        if (Hash::check($request->old_password, auth()->user()->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        } else {
            return response()->json(["message" => trans("auth.messages.wrong-password")], 422);
        }

        return response()->json(["message" =>trans("auth.messages.password-changed")], 200);
        ;
    }
}
