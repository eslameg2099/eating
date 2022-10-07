@canany(['delete', 'restore', 'forceDelete','extractExcel'], $model)
    <input type="checkbox"
           name="items[]"
           value="{{ $model->id }}"
           class="item-checkbox">
@else
    <input type="checkbox" disabled>
@endcanany