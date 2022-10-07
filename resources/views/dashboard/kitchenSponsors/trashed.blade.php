<x-layout :title="trans('category.trashed')" :breadcrumbs="['dashboard.categories.trashed']">
    @include('dashboard.categories.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('category.actions.list') ({{ count_formatted($categories->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-force-delete
                            type="{{ \App\Models\Category::class }}"
                            :resource="trans('category.plural')"></x-check-all-force-delete>
                    <div class="ml-2">
                        <x-check-all-restore
                                type="{{ \App\Models\Category::class }}"
                                :resource="trans('category.plural')"></x-check-all-restore>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('category.attributes.title')</th>
            <th>@lang('category.attributes.created_at')</th>
            <th>@lang('category.attributes.deleted_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr >
                <td>
                    <x-check-all-item :model="$category"></x-check-all-item>
                </td>
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
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->deleted_at ?? '--'}}</td>
                <td style="width: 160px">
                    @include('dashboard.categories.partials.actions.show', ['category' => $category])
                    @include('dashboard.categories.partials.actions.restore', ['category' => $category])
{{--                    @include('dashboard.categories.partials.actions.forceDelete', ['category' => $message])--}}
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
