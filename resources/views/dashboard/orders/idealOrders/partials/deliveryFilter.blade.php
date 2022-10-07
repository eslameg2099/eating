{{ BsForm::resource('orders')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('orders.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('delivery_company')->value(request('delivery_company'))->label(trans('orders.delivery.delivery_company')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::date('from_date')->value(old('from_date'))->label(__('من')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::date('to_date')->value(old('to_date'))->label(__('إلي')) }}
        </div>

    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('admins.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
