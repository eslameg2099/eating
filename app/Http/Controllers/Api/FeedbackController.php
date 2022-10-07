<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use App\Events\FeedbackSent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FeedbackController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the feedback.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'message' => 'required',
        ], [], trans('feedback.attributes'));

        try {
            $feedback = Feedback::create($request->all());
        } catch (\Throwable $exception) {
            return response()->json("Something Went Wrong", 500);
        }
        event(new FeedbackSent($feedback));

        return response()->json([
            'message' => trans('feedback.messages.sent'),
        ]);
    }
}
