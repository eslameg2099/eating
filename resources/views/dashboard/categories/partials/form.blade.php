@include('dashboard.errors')
@bsMultilangualFormTabs
{{ BsForm::text('title')->label(trans('category.attributes.title')) }}
@endBsMultilangualFormTabs
{{ BsForm::checkbox('active_at', \Carbon\Carbon::now())->label(@trans('category.attributes.active') )->checked(true) }}

@isset($category)
    {{ BsForm::image('default')->collection('default')->files($category->getMediaResource('default'))->label(trans('category.attributes.image')) }}
@else
    {{ BsForm::image('default')->collection('default')->label(trans('category.attributes.image')) }}
@endisset

@slot('footer')
    {{ BsForm::submit()->label(trans('category.actions.save')) }}
@endslot
