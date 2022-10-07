@include('dashboard.errors')
{{ BsForm::number('user_id')->required() }}
{{ BsForm::text('name')->required() }}
{{ BsForm::text('address')->required() }}
{{ BsForm::text('description')->required() }}
{{ BsForm::select('city_id')->required()->label(@trans('kitchen.attributes.city'))->options($cities)->placeholder('اختر المدينة')}}
{{ BsForm::select('cookable_type')->required()->options(@trans('kitchen.types'))->placeholder('اختر النوع')}}
{{--{{ BsForm::text('longitude')->required() }}--}}
{{--{{ BsForm::text('latitude')->required() }}--}}
{{ BsForm::checkbox('verified_at', \Carbon\Carbon::now())->label(@trans('kitchen.attributes.activation') )->checked(true) }}
{{ BsForm::checkbox('active', 1)->label(@trans('kitchen.attributes.receive-orders'))->checked(true) }}
{{ BsForm::checkbox('active_special', 1)->label(@trans('kitchen.attributes.receive-special'))->checked(true) }}
{{--{{ BsForm::text('address')->attribute('readonly', 'readonly') }}--}}

<google-map-marker
        :initial-lat-value="{{ $kitchen->latitude ?? 24.700548606169395 }}"
        :initial-lng-value="{{ $kitchen->longitude ?? 46.64410303322909 }}"
        :zoom="{{ isset($kitchen) ? 8 : 5 }}"
></google-map-marker>
<div class="row p-3">
    <div class="col col-3">
@isset($kitchen)
    {{ BsForm::image('default')->collection('default')->files($kitchen->getMediaResource('default')) }}
    <file-uploader
            :media="{{ isset($kitchen) ? $kitchen->getMediaResource('attach') : old('attach')}}"
            collection="attach"
            :tokens="{{ json_encode(old('media', [])) }}"
            label="{{trans('kitchen.attributes.evidence')}}"
            notes="xlx,csv,pdf"
    ></file-uploader>

@else
    {{ BsForm::image('default')->collection('default') }}
    <file-uploader
           collection="attach"
           :tokens="{{ json_encode(old('media', [])) }}"
           label="{{trans('kitchen.attributes.evidence')}}"
           notes="xlx,csv,pdf"
    ></file-uploader>
@endisset
    </div>
    <div class="col col-3">
@isset($kitchen)
@if($kitchen->getFirstMediaUrl('attach'))
    <label>@lang('kitchen.attributes.evidence')</label>
        <br>
    <a type="button" class="btn btn-info" href="{{$kitchen->getFirstMediaUrl('attach')}}" download>
        @lang('kitchen.attributes.evidence')  <i class="fas fa-file-download"></i></a>
@endif
@endisset
    </div>
    <div class="col col-6"></div>
</div>

