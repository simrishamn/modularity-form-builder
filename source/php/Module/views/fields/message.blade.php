<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
		<label class="label-bold" for="{{ $module_id }}-message">{{ $field['label'] ? $field['label'] : 'Message' }}{!!  $field['required'] ? '<span class="text-danger">*</span>' : '' !!}</label>
        <fieldset class="form-group">
            {!! !empty($field['description']) ? '<legend class="text-sm text-dark-gray">' . ModularityFormBuilder\Helper\SanitizeData::convertLinks($field['description']) . '</legend>' : '' !!}

            <textarea name="{{ sanitize_title($field['label']) }}" id="{{ $module_id }}-message" rows="10" {{ $field['required'] ? 'required' : '' }}></textarea>
            @if (isset($field['custom_post_type_content']) && $field['custom_post_type_content'] == true)
                <input type="hidden" name="post_content" value="{{ sanitize_title($field['label']) }}">
            @endif
        </fieldset>
    </div>
</div>
