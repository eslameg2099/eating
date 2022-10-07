{{ BsForm::resource('feedback')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('feedback.filter'))

    <div class="row">
        <div class="col-md-9 d-flex align-items-end">
            <div class="col-md-4 d-flex align-items-end">
                {{BsForm::number('order_id')->value(request('order_id'))->label(trans('reports.attributes.order'))}}
            </div>
            <div class="col-md-4 d-flex align-items-end">
                {{BsForm::text('customer')->value(request('customer'))->label(trans('reports.attributes.customer'))}}
            </div>
            <div class="col-md-4 d-flex align-items-end">
                {{BsForm::text('kitchen')->value(request('kitchen'))->label(trans('reports.attributes.kitchen'))}}
            </div>

        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('feedback.perPage')) }}
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="col-md-3 d-flex align-items-end">
                {{ BsForm::radio('read_at')
                    ->value('read')
                    ->checked(!is_null(request('read_at')))
                     ->label(trans('feedback.attributes.read')) }}
            </div>
            <div class="col-md-3 d-flex align-items-end">
                {{ BsForm::radio('read_at')
                    ->value('unread')
                    ->checked(is_null(request('read_at')))
                     ->label(trans('feedback.attributes.unread')) }}
            </div>
            <div class="col-md-3 d-flex align-items-end">
                {{ BsForm::radio('read_at')
                    ->value('all')
                    ->checked(!request('read_at'))
                     ->label(trans('feedback.actions.list')) }}
            </div>
        </div>


    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('feedback.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
