<x-layout :title="trans('packages.trashed')" :breadcrumbs="['dashboard.packages.trashed']">
    @include('dashboard.packages.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('packages.actions.list') ({{ $packages->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <x-check-all-force-delete
                    type="{{ \App\Models\Package::class }}"
                    :resource="trans('packages.plural')"></x-check-all-force-delete>
            <x-check-all-restore
                    type="{{ \App\Models\Package::class }}"
                    :resource="trans('packages.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('packages.attributes.name')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($packages as $package)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$package"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.packages.trashed.show', $package) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $package->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.packages.partials.actions.show')
                    @include('dashboard.packages.partials.actions.restore')
                    @include('dashboard.packages.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('packages.empty')</td>
            </tr>
        @endforelse

        @if($packages->hasPages())
            @slot('footer')
                {{ $packages->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
