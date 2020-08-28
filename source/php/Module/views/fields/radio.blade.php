<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
        <fieldset class="form-group">
						<legend class="label-bold">{{ $field['label'] }}{!!  $field['required'] ? '<span class="text-danger">*</span>' : '' !!}</legend>
						{!! !empty($field['description']) ? '<span class="text-sm text-dark-gray">' . ModularityFormBuilder\Helper\SanitizeData::convertLinks($field['description']) . '</span>' : '' !!}

            @foreach ($field['values'] as $value)
            <label class="checkbox">
                <input type="radio" name="{{ sanitize_title($field['label']) }}" value="{{ $value['value'] }}" {{ $field['required'] ? 'required' : '' }} conditional='{{ $value['conditional_value'] }}'> {{ $value['value'] }}
            </label>
            @endforeach
				</fieldset>
    </div>
</div>
