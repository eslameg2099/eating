<button class="btn btn-outline-success btn-sm"
        data-checkbox=".item-checkbox"
        data-form="accept-selected-form"
        data-toggle="modal"
        data-target="#accept-selected-model">
    <i class="fas fa-add"></i>
    @lang('check-all.actions.accept')
</button>

<!-- Modal -->
<div class="modal fade" id="accept-selected-model" tabindex="-1" role="dialog"
     aria-labelledby="selected-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selected-modal-title">
                    @lang('check-all.dialogs.accept.title')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-success">
                @lang('check-all.dialogs.accept.info', ['type' => $resource ?? ''])
                <form action="{{ route('dashboard.kitchens.requests.accept.selected') }}"
                      id="accept-selected-form"
                      method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="type" value="{{ $type ?? '' }}">
                    <input type="hidden" name="resource" value="{{ $resource ?? '' }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    @lang('check-all.dialogs.accept.cancel')
                </button>
                <button type="submit" class="btn btn-success btn-sm" form="accept-selected-form">
                    @lang('check-all.dialogs.accept.confirm')
                </button>
            </div>
        </div>
    </div>
</div>