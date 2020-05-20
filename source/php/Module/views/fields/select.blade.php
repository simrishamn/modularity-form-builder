<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
		<label class="label-bold" for="{{ $module_id }}-{{ sanitize_title($field['label']) }}">{{ $field['label'] }}{!!  $field['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <fieldset class="form-group">
            {!! !empty($field['description']) ? '<legend class="text-sm text-dark-gray">' . ModularityFormBuilder\Helper\SanitizeData::convertLinks($field['description']) . '</legend>' : '' !!}

            <select name="{{ sanitize_title($field['label']) }}" id="{{ $module_id }}-{{ sanitize_title($field['label']) }}">
            @foreach ($field['values'] as $value)
            <option value="{{ $value['value'] }}">{{ $value['value'] }}</option>
            @endforeach
            </select>
        </fieldset>
    </div>
</div>
