@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('email') }}
{{ BsForm::text('phone') }}
{{ BsForm::select('city_id')->required()->label(@trans('chefs.attributes.city'))->options($cities)->placeholder('اختر المدينة')}}
{{ BsForm::checkbox('phone_verified_at', \Carbon\Carbon::now())->label('تفعيل العضوية')->checked(true) }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}

@isset($customer)
    {{ BsForm::image('avatar')->collection('avatars')->files($customer->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
