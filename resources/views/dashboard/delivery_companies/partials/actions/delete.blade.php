@can('delete', $delivery_company)
    <a href="#delivery_company-{{ $delivery_company->id }}-delete-model"
       class="btn btn-outline-danger btn-sm"
       data-toggle="modal">
        <i class="fas fa fa-fw fa-trash"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="delivery_company-{{ $delivery_company->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $delivery_company->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $delivery_company->id }}">@lang('delivery_companies.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('delivery_companies.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.delivery_companies.destroy', $delivery_company)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('delivery_companies.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('delivery_companies.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@endcan
