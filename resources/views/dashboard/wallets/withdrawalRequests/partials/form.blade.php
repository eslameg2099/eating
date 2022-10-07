@include('dashboard.errors')
{{ BsForm::select('status')->placeholder(__("الكل"))->options(trans("orders.modifiable_statuses"))->required() }}
