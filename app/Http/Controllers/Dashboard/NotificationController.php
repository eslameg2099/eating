<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\NotificationsHandlerTrait;
use App\Models\User;
use App\Traits\HISMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use App\Notifications\Channels\PusherChannel;
use App\Models\SmsLog;
use App\Notifications\CustomNotification;
use Laraeast\LaravelSettings\Facades\Settings;
use App\Models\Notification as NotificationModel;

class NotificationController extends Controller
{
    use HISMS, NotificationsHandlerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.notifications.index');
    }
    public function certain()
    {
        $users  =   User::query()
            ->whereIn('type', [User::CUSTOMER_TYPE,User::CHEF_TYPE])
            ->get();
        return view('dashboard.notifications.show',
            [
                'users'     => $users->where('type', User::CUSTOMER_TYPE),
                'chefs'     => $users->where('type', User::CHEF_TYPE),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Settings::get('name', 'Homez App')
        
        
        
           $this->checkAndSendNotification($request);
         
            flash()->success(trans('notifications.messages.sent'));
           return redirect()->route('dashboard.notifications.index');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
