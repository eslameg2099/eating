<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    protected $table    =   'sms_logs';
    protected $guarded  =   ['id'];

    const VerifyCode    = 1;
    const ResetPassword = 2;
    const ChangePhoneNumber = 3;
    const ComplaintSms  =   4;
    const AdminNotification  =   5;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
}
