<x-layout :title="$category->title" :breadcrumbs="['dashboard.categories.show', $category]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('category.attributes.title')</th>
                        <td>{{ $category->title }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('category.attributes.active')</th>
                        <td>
                            @if($category->active_at)
                                <i class="far fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle">
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th width="200">@lang('category.attributes.image')</th>
                        <td>
                            @if($category->getFirstMedia('default'))
                                <file-preview :media="{{ $category->getMediaResource('default') }}"></file-preview>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
{{--                    @include('dashboard.categories.partials.actions.delete')--}}
                    @include('dashboard.categories.partials.actions.edit', ['category' => $category])
{{--                    @include('dashboard.categories.partials.actions.restore')--}}
{{--                    @include('dashboard.categories.partials.actions.forceDelete')--}}
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
