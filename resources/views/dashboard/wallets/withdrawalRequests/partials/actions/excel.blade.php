<button type="submit" class="btn btn-default btn-sm"
        data-checkbox=".item-checkbox"
        data-form="download-excel"
        form="download-excel">
    <i class="fas fa-file-excel"></i>
    @lang('wallets.excel')
</button>
{{ BsForm::patch(route('dashboard.wallets.withdrawals.excel'), ['id' => 'download-excel', 'class' => 'd-none']) }}
{{ BsForm::close() }}