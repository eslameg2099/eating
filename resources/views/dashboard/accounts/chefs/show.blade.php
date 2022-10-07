<x-layout :title="$chef->name" :breadcrumbs="['dashboard.chefs.show', $chef]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('chefs.attributes.name')</th>
                <td>{{ $chef->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('chefs.attributes.email')</th>
                <td>{{ $chef->email }}</td>
            </tr>
            <tr>
                <th width="200">@lang('chefs.attributes.phone')</th>
                <td>
                    @include('dashboard.accounts.chefs.partials.flags.phone')
                </td>
            </tr>
            <tr>
                <th width="200">@lang('chefs.attributes.avatar')</th>
                <td>
                    @if($chef->getFirstMedia('avatars'))
                        <file-preview :media="{{ $chef->getMediaResource('avatars') }}"></file-preview>
                    @else
                        <img src="{{ $chef->getAvatar() }}"
                             class="img img-size-64"
                             alt="{{ $chef->name }}">
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        @slot('footer')
            @include('dashboard.accounts.chefs.partials.actions.kitchen')
            @include('dashboard.accounts.chefs.partials.actions.edit')
            @include('dashboard.accounts.chefs.partials.actions.delete')
            @include('dashboard.accounts.chefs.partials.actions.restore')
            @include('dashboard.accounts.chefs.partials.actions.forceDelete')
        @endslot
    @endcomponent
</x-layout>
