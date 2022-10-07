@include('dashboard.errors')

<div class="row">
    <div class="col-6">
        {{ BsForm::text('title')->required() }}
        {{ BsForm::number('limit') }}
    </div>
    <div class="col-6">
        {{ BsForm::number('discount_percentage')->required() }}

        {{ BsForm::date('expire_date') }}
    </div>
</div>



