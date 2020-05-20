<div class="grid mod-form-field" {!! $field['conditional_hidden'] !!}>
    <div class="grid-md-12">
			<fieldset class="form-group">
			{!! !empty($field['description']) ? '<legend class="text-sm text-dark-gray">' . ModularityFormBuilder\Helper\SanitizeData::convertLinks($field['description']) . '</legend>' : '' !!}
				{!! $field['content'] !!}
			</fieldset>
    </div>
</div>
