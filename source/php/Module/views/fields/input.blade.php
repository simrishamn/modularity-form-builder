<?php

use ModularityFormBuilder\Helper\SanitizeData;

?>

<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
        <fieldset class="form-group">
            {!! (new ModularityFormBuilder\Helper\RenderInput($field['value_type'], $field['label'], $field)) !!}

            @if (isset($field['custom_post_type_title']) && $field['custom_post_type_title'] == true)
                <input type="hidden" name="post_title" value="{{ sanitize_title($field['label']) }}">
            @endif
        </fieldset>
    </div>
</div>
