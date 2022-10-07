@include('dashboard.errors')
@bsMultilangualFormTabs
{{ BsForm::text('title')->label(trans('sponsorship.attributes.title')) }}
{{ BsForm::text('currency')->label(trans('sponsorship.attributes.currency'))->placeholder('مثال: ريال سعودي') }}

@endBsMultilangualFormTabs
<hr style="width:50%;text-align:right;margin-right:0;background-color: #748290">
{{ BsForm::number('cost')->label(trans('sponsorship.attributes.cost'))}}
<div class="row">
    <div class="col-sm">
        {{BsForm::select('duration_type')->options(trans('sponsorship.duration_type'))->label(trans('sponsorship.attributes.duration_type'))}}
    </div>
    <div class="col-sm">
        {{ BsForm::number('duration')->label(trans('sponsorship.attributes.duration'))->placeholder('مثال: 1,2,3 ...') }}
    </div>
</div>

{{ BsForm::checkbox('active', 1)->label(@trans('sponsorship.attributes.active'))->checked(true) }}


@slot('footer')
    {{ BsForm::submit()->label(trans('sponsorship.actions.save')) }}
@endslot
