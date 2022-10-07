@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::email('email')->required() }}
{{ BsForm::text('phone')->required() }}
{{ BsForm::password('password')->attribute('autocomplete', '0') }}
{{ BsForm::password('password_confirmation') }}
@isset($admin)
    {{ BsForm::image('avatar')->collection('avatars')->files($admin->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
