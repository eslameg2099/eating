<x-layout :title="$category->title" :breadcrumbs="['dashboard.categories.edit', $category]">
    {{ BsForm::resource('categories')->putModel($category, route('dashboard.categories.update', $category), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('category.actions.edit'))

        @include('dashboard.categories.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('category.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
