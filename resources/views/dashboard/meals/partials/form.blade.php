@include('dashboard.errors')
{{ BsForm::text('name')->required()->label(trans('meal.attributes.name')) }}
{{ BsForm::number('kitchen_id')->required()->label(trans('meal.attributes.kitchen_id')) }}
{{ BsForm::select('category_id')->required()->placeholder(__('الكل'))->options(\App\Models\Category::listsTranslations('title')->pluck('title','id'))->label(trans('meal.attributes.category_id')) }}
{{ BsForm::textarea('description')->required()->label(trans('meal.attributes.description')) }}
{{ BsForm::number('cost')->required()->label(trans('meal.attributes.cost')) }}
{{ BsForm::number('cost_after_discount')->label(trans('meal.attributes.cost_after_discount')) }}
@isset($meal)
    {{ BsForm::image('avatar')->unlimited()->collection('Meal')->files($meal->getMediaResource('Meal')) }}
@else
    {{ BsForm::image('avatar')->unlimited()->collection('Meal') }}
@endisset
{{--@isset($meal)--}}
{{--    {{ BsForm::image('Meal')->unlimited()->collection('Meal') }}--}}
{{--@endisset--}}
@slot('footer')
    {{ BsForm::submit()->label(trans('meal.actions.save')) }}
@endslot
