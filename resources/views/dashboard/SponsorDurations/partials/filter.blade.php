{{ BsForm::resource('category')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('category.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('title')->value(request('title')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('category.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('category.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
