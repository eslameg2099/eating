@include('dashboard.errors')
{{ BsForm::select('user_type')->options(trans("notifications.form.user_type")) }}
{{ BsForm::text('title')->placeholder(__("عنوان الرسالة"))->required() }}
{{ BsForm::textarea('body')->required() }}
