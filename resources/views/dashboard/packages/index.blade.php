<x-layout :title="trans('packages.plural')" :breadcrumbs="['dashboard.packages.index']">
    @include('dashboard.packages.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('packages.actions.list') ({{ $packages->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\Package::class }}"
                        :resource="trans('packages.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.packages.partials.actions.create')
                    @include('dashboard.packages.partials.actions.trashed')
                </div>
            </div>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('packages.attributes.name')</th>
            <th>@lang('packages.attributes.from_kg')</th>
            <th>@lang('packages.attributes.to_kg')</th>
            <th>@lang('packages.attributes.cost')</th>
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
                    <a href="{{ route('dashboard.packages.show', $package) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $package->name }}
                    </a>
                </td>
                <td>{{$package->from_kg}}</td>
                <td>{{$package->to_kg}}</td>
                <td>{{$package->cost}}</td>
                <td style="width: 160px">
                    @include('dashboard.packages.partials.actions.show')
                    @include('dashboard.packages.partials.actions.edit')
                    @include('dashboard.packages.partials.actions.delete')
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
