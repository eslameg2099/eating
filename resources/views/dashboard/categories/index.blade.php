<x-layout :title="trans('category.plural')" :breadcrumbs="['dashboard.categories.index']">
    @include('dashboard.categories.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('category.actions.list') ({{ count_formatted($categories->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
{{--                    <x-check-all-delete--}}
{{--                            type="{{ \App\Models\Category::class }}"--}}
{{--                            :resource="trans('category.plural')"></x-check-all-delete>--}}
                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        <div>
                            @include('dashboard.categories.partials.actions.create')
                        </div>
{{--                        @include('dashboard.categories.partials.actions.trashed')--}}
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('category.attributes.title')</th>
            <th>@lang('category.attributes.active')</th>
            <th>@lang('category.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>
                    <x-check-all-item :model="$category"></x-check-all-item>
                </td>
                <td>
                    <img src="{{ $category->getFirstMediaUrl() }}"
                         alt="Product 1"
                         class="img-circle img-size-32 mr-2">
                    <a href="{{ route('dashboard.feedback.show', $category) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $category->title }}
                    </a>
                </td>
                <td>
                    @if($category->active_at)
                        <i class="far fa-check-circle"></i>
                    @else
                        <i class="fas fa-times-circle">
                    @endif
                </td>
                <td>{{ $category->created_at }}</td>

                <td style="width: 160px">
                    @include('dashboard.categories.partials.actions.show', ['category' => $category])
                    @include('dashboard.categories.partials.actions.edit', ['category' => $category])
{{--                    @include('dashboard.categories.partials.actions.delete', ['category' => $category])--}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('category.empty')</td>
            </tr>
        @endforelse

        @if($categories->hasPages())
            @slot('footer')
                {{ $categories->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
