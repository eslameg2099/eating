@include('dashboard.errors')
{{ BsForm::number('user_id')->placeholder(__("رقم العضوية"))->required() }}
{{ BsForm::text('title')->placeholder(__("عنوان الرسالة"))->required() }}
{{ BsForm::textarea('body')->required() }}
