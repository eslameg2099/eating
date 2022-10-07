{{ BsForm::resource('kitchen')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('kitchen.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('chef')->value(request('chef')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('cookable_type')->required()->options(@trans('kitchen.types'))->placeholder('اختر النوع')}}
        </div>

        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                ->label(trans('kitchen.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('kitchen.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
