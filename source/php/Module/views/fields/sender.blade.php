{{-- Firstname and/or lastname --}}
@foreach($field['fields'] as $acf_field)
    {{-- $id = uniqid() --}}
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-{{ $acf_field }}">
                    {{ $field['labels'][$acf_field] }}
                    {!! in_array($acf_field, $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <input type="text"
                       name="{{ uniqid() . '-' . sanitize_title($field['labels'][$acf_field]) }}"
                       value="{{ $user_details[$acf_field] }}"
                       id="{{ $module_id }}-{{ $acf_field }}"
                       {{ in_array($acf_field, $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
    </div>
@endforeach

{{-- Email and/or phone --}}
@if (in_array('email', $field['fields']) && in_array('phone', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-email">{{ $field['labels']['email'] }}{!! in_array('email', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                <input type="email" name="{{ sanitize_title($field['labels']['email']) }}" value="{{ $user_details['email'] }}" id="{{ $module_id }}-email" {{ in_array('email', $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-phone">{{ $field['labels']['phone'] }}{!! in_array('phone', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                <input type="tel" name="{{ sanitize_title($field['labels']['phone']) }}" id="{{ $module_id }}-phone" {{ in_array('phone', $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
    </div>
@elseif (in_array('email', $field['fields']) && !in_array('phone', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-email">{{ $field['labels']['email'] }}{!! in_array('email', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                <input type="email" name="{{ sanitize_title($field['labels']['email']) }}" value="{{ $user_details['email'] }}" id="{{ $module_id }}-email" {{ in_array('email', $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
    </div>
@elseif (!in_array('email', $field['fields']) && in_array('phone', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-phone">{{ $field['labels']['phone'] }}{!! in_array('phone', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                <input type="tel" name="{{ sanitize_title($field['labels']['phone']) }}" id="{{ $module_id }}-phone" {{ in_array('phone', $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
    </div>
@endif

{{-- Address --}}
 @if (in_array('address', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-12">
            <div class="form-group">
                <label for="{{ $module_id }}-address-street">{{ $field['labels']['street_address'] }}{!! in_array('address', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                @if ($googleGeocoding)
                <div class="input-group">
                    <input type="text" name="{{ sanitize_title($field['labels']['address']) }}[{{ sanitize_title($field['labels']['street_address']) }}]" class="form-control" id="{{ $module_id }}-address-street" {{ in_array('address', $field['required_fields']) ? 'required' : '' }}>
                    <span class="input-group-addon-btn"><button id="form-get-location" class="btn"><i class="pricon pricon-location-pin"></i> <?php _e('Find my location', 'modularity-form-builder'); ?></button></span>
                </div>
                @else
                    <input type="text" name="{{ sanitize_title($field['labels']['address']) }}[{{ sanitize_title($field['labels']['street_address']) }}]" class="form-control" id="{{ $module_id }}-address-street" {{ in_array('address', $field['required_fields']) ? 'required' : '' }}>
                @endif
            </div>
        </div>
    </div>
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-address-postal-code">{{ $field['labels']['postal_code'] }}{!! in_array('address', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                <input type="text" name="{{ sanitize_title($field['labels']['address']) }}[{{ sanitize_title($field['labels']['postal_code']) }}]" id="{{ $module_id }}-address-postal-code" {{ in_array('address', $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
        <div class="grid-md-6">
            <div class="form-group">
                <label for="{{ $module_id }}-address-city">{{ $field['labels']['city'] }}{!! in_array('address', $field['required_fields']) ? '<span class="text-danger">*</span>' : '' !!}</label>
                <input type="text" name="{{ sanitize_title($field['labels']['address']) }}[{{ sanitize_title($field['labels']['city']) }}]" id="{{ $module_id }}-address-city" {{ in_array('address', $field['required_fields']) ? 'required' : '' }}>
            </div>
        </div>
    </div>
@endif
