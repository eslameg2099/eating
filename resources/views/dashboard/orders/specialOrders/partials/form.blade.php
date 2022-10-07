@include('dashboard.errors')
{{ BsForm::select('status')->placeholder(__("الكل"))->options(trans("specialOrders.modifiable_statuses"))->required() }}
