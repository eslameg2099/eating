@can('accept', $kitchen)
    <a href="#admin-{{ $kitchen->id }}-accept-model"
       class="btn btn-outline-success btn-sm"
       data-toggle="modal">
        <i class="fas fa fa-fw fa-user-check"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="admin-{{ $kitchen->id }}-accept-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $kitchen->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $kitchen->id }}">@lang('kitchen.dialogs.accept.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('kitchen.dialogs.accept.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::put(route('dashboard.kitchens.requests.accept', $kitchen)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('kitchen.dialogs.accept.cancel')
                    </button>
                    <button type="submit" class="btn btn-success">
                        @lang('kitchen.dialogs.accept.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@endcan
