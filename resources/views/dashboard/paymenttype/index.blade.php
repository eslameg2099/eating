<x-layout :title="trans('types.plural')" :breadcrumbs="['dashboard.types.index']">

    @component('dashboard::components.table-box')
        @slot('title')
          
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <div class="d-flex">
                
                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                 
                </div>
            </div>
          </th>
        </tr>
        <tr>
          
            <th>@lang('cities.attributes.name')</th>
            <th> الحالة </th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($TypePayments as $city)
            <tr>
              
                <td>
                   
                        {{ $city->name }}
                   
                </td>
                <td>
                   
                @if($city->active == '1' )
                <span class="badge badge-success">مفعل</span>
                    @elseif($city->active == '0' )
                    <span class="badge badge-danger">غير مفعل</span>
                    @endif
           </td> 

                <td style="width: 160px">
                    @include('dashboard.paymenttype.partials.actions.edit')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('cities.empty')</td>
            </tr>
        @endforelse

        @if($TypePayments->hasPages())
            @slot('footer')
                {{ $TypePayments->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
