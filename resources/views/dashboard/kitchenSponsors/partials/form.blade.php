@include('dashboard.errors')
{{--@bsMultilangualFormTabs--}}
{{--{{ BsForm::text('title')->label(trans('category.attributes.title')) }}--}}
{{--@endBsMultilangualFormTabs--}}
@isset($category)
    {{ BsForm::image('default')->collection('default')->files($kitchenDuration->getMediaResource('default'))->label(trans('kitchensponsor.attributes.avatar')) }}
@else
    {{ BsForm::image('default')->collection('default')->label(trans('kitchensponsor.attributes.avatar')) }}
@endisset

@slot('footer')
    {{ BsForm::submit()->label(trans('kitchensponsor.actions.save')) }}
@endslot
