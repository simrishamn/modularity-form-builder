<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
        <fieldset class="form-group">
						<legend class="label-bold">{{ $field['label'] }}{!!  $field['required'] ? '<span class="text-danger">*</span>' : '' !!}</legend>
						{!! !empty($field['description']) ? '<span class="text-sm text-dark-gray">' . ModularityFormBuilder\Helper\SanitizeData::convertLinks($field['description']) . '</span>' : '' !!}
            @if ($field['type'] === 'multiple')
            <ul class="input-files" data-max="{{ $field['files_max'] }}">
                <li>
                    <label for="{{ sanitize_title($field['label']) }}[]" class="input-file">
                        <input id="{{ sanitize_title($field['label']) }}[]" type="file" name="{{ sanitize_title($field['label']) }}[]" {!! $field['filetypes'] && is_array($field['filetypes']) ? 'accept="' . implode(',', $field['filetypes']) . '"' : '' !!} {{ $field['required'] ? 'required' : '' }} multiple>
                        <span class="btn"><?php _e('Select file', 'modularity-form-builder'); ?></span>
                        <span class="input-file-selected"><?php _e('No file selected', 'modularity-form-builder'); ?></span>
                    </label>
                </li>
            </ul>
            @else
                <label for="{{ sanitize_title($field['label']) }}[]" class="input-file">
                    <input id="{{ sanitize_title($field['label']) }}[]" type="file" name="{{ sanitize_title($field['label']) }}[]" {!! $field['filetypes'] && is_array($field['filetypes']) ? 'accept="' . implode(',', $field['filetypes']) . '"' : '' !!} {{ $field['required'] ? 'required' : '' }}>
                    <span class="btn"><?php _e('Select file', 'modularity-form-builder'); ?></span>
                    <span class="input-file-selected"><?php _e('No file selected', 'modularity-form-builder'); ?></span>
                </label>
            @endif
        </fieldset>
    </div>
</div>
