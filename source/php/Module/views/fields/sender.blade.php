{{-- Firstname and/or lastname --}}
@if (in_array('firstname', $field['fields']) && in_array('lastname', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'firstname', $field, $user_details); @endphp
            </div>
        </div>
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'lastname', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@elseif (in_array('firstname', $field['fields']) && !in_array('lastname', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'firstname', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@elseif (!in_array('firstname', $field['fields']) && in_array('lastname', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'lastname', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@endif

{{-- Email and/or phone --}}
@if (in_array('email', $field['fields']) && in_array('phone', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('email', 'email', $field, $user_details); @endphp
            </div>
        </div>
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('tel', 'phone', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@elseif (in_array('email', $field['fields']) && !in_array('phone', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('email', 'email', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@elseif (!in_array('email', $field['fields']) && in_array('phone', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('tel', 'phone', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@endif

{{-- Address --}}
 @if (in_array('address', $field['fields']))
    <div class="grid mod-form-field">
        <div class="grid-md-12">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'street_address', $field, $user_details, ['googleGeocoding' => $googleGeocoding]); @endphp
            </div>
        </div>
    </div>
    <div class="grid mod-form-field">
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'postal_code', $field, $user_details); @endphp
            </div>
        </div>
        <div class="grid-md-6">
            <div class="form-group">
                @php new ModularityFormBuilder\Helper\RenderInput('text', 'city', $field, $user_details); @endphp
            </div>
        </div>
    </div>
@endif
