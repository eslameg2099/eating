{{ BsForm::resource('wallets')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('wallets.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('id')->value(request('id')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('phone')->value(request('phone')) }}
        </div>
{{--        <div class="col-md-3">--}}
{{--            {{ BsForm::number('balance')->value(request('balance')) }}--}}
{{--        </div>--}}
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
            @lang('wallets.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
