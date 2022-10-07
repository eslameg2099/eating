<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->simplePaginate();
        foreach ($notifications as $unread){
            $unread->markAsRead();
        }
        return NotificationResource::collection($notifications);
    }
    /**
     * Retrieve the count of the unread notifications with json response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        $notificationsCount = 0;
        if (auth('sanctum')->user()) {
            $notificationsCount = auth('sanctum')->user()->unreadNotifications()->count();
        }
        return response()->json([
            'notifications_count' => $notificationsCount,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
