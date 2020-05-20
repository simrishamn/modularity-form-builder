<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
		<label class="label-bold" for="{{ $module_id }}-{{ sanitize_title($field['label']) }}">{{ $field['label'] }}{!!  $field['required'] ? '<span class="text-danger">*</span>' : '' !!}</label>
        <fieldset class="form-group">
            {!! !empty($field['description']) ? '<legend class="text-sm text-dark-gray">' . ModularityFormBuilder\Helper\SanitizeData::convertLinks($field['description']) . '</legend>' : '' !!}

            @foreach ($field['values'] as $value)
                <label class="checkbox">
                    <input type="checkbox" class="{{ $field['required'] ? 'required' : '' }}" name="{{ sanitize_title($field['label']) }}[]" value="{{ $value['value'] }}"> {{ $value['value'] }}
                </label>
            @endforeach
        </fieldset>
    </div>
</div>
