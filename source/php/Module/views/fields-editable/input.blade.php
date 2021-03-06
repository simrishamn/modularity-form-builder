<?php

use ModularityFormBuilder\Helper\SanitizeData;

?>

<div class="mod-form-field">
    <p>
        <b>
            <label for="{{ $module_id }}-input-{{ $field['name'] }}">
                {{ $field['label'] }}
                @if ($field['required'])
                    <span class="text-danger">*</span>
                @endif
            </label>
        </b>
    </p>

    <input
        type="{{ $field['value_type'] }}"
        id="{{ $module_id }}-input-{{ $field['name'] }}"
        class="large-text"
        name="mod-form[{{ $field['name'] }}]"
        value="{{ $field['value'] }}"
        @if ($field['required'])
            required="required"
        @endif
        @if ($field['value_type'] == 'date')
            min="{{ SanitizeData::formatDate($field['min_value']) }}"
            max="{{ SanitizeData::formatDate($field['max_value']) }}"
        @elseif (($field['value_type'] == 'time'))
            @if (!empty($field['min_time_value'])) min="{{ trim($field['min_time_value']) }}" @endif
            @if (!empty($field['max_time_value'])) max="{{ trim($field['max_time_value']) }}" @endif
        @elseif (in_array($field['value_type'], array('number', 'range')))
            @if (!empty($field['min_value'])) min="{{ trim($field['min_value']) }}" @endif
            @if (!empty($field['max_value'])) max="{{ trim($field['max_value']) }}" @endif
            @if (!empty($field['step'])) step="{{ trim($field['step']) }}" @endif
        @endif
    >
</div>
