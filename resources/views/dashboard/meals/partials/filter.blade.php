{{ BsForm::resource('category')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('meal.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name'))->label(trans('meal.attributes.name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('kitchen_id')->value(request('kitchen_id'))->label(trans('meal.attributes.kitchen_id')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('category_id')->placeholder(__('الكل'))->options(\App\Models\Category::listsTranslations('title')->pluck('title','id'))->label(trans('meal.attributes.category')) }}
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
