<x-layout :title="trans('settings.tabs.main')" :breadcrumbs="['dashboard.settings.index']">
    {{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')
        {{BsForm::number('admin_commission')->required()->value(Settings::get('admin_commission'))}}
        {{BsForm::number('delivery_cost')->required()->value(Settings::get('delivery_cost'))}}
        {{BsForm::number('tax_ratio')->required()->value(Settings::get('tax_ratio'))}}
        {{BsForm::number('additional_added_tax')->required()->value(Settings::get('additional_added_tax'))}}
        {{BsForm::number('systen_profit')->required()->value(Settings::get('systen_profit'))}}

        
        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>