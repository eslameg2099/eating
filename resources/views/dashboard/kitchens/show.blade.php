<x-layout :title="$kitchen->name" :breadcrumbs="['dashboard.kitchens.show', $kitchen]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('kitchen.attributes.name')</th>
                <td>{{ $kitchen->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('kitchen.attributes.user_id')</th>
                <td>{{ $kitchen->user->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('kitchen.attributes.cookable_type')</th>
                <td>{{ $kitchen->cookable_type }}</td>
            </tr>
            <tr>
                <th width="200">@lang('kitchen.attributes.description')</th>
                <td>{{ $kitchen->description }}</td>
            </tr>
            <tr>
                <th width="200">@lang('kitchen.attributes.default')</th>
                <td>
                    @if($kitchen->getFirstMedia('default'))
                        <file-preview :media="{{ $kitchen->getMediaResource('default') }}"></file-preview>
                    @else
                        <img src="{{ $kitchen->getMediaResource('default') }}"
                             class="img img-size-64"
                             alt="{{ $kitchen->name }}">
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        @slot('footer')
            @include('dashboard.kitchens.partials.actions.edit')
{{--            @include('dashboard.kitchens.partials.actions.delete')--}}
{{--            @include('dashboard.kitchens.partials.actions.restore')--}}
{{--            @include('dashboard.kitchens.partials.actions.forceDelete')--}}
        @endslot
    @endcomponent
</x-layout>
