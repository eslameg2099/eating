{{ BsForm::resource('orders')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('orders.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('id')->value(request('id')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('kitchen')->value(request('kitchen')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('status')->value(request('status'))->options(trans('orders.statuses')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                ->label(trans('admins.perPage')) }}
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
