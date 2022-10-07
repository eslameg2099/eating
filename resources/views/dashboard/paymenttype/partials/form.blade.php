@include('dashboard.errors')
<h4> الحالة</h4>
{{ BsForm::checkbox('active')->value(1)->withDefault()->checked($TypePayment->active ?? old('active')) }}