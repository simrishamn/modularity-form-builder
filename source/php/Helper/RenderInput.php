<?php
declare(strict_types=1);

namespace ModularityFormBuilder\Helper;

/**
 * Updated: 2019-04-10
 * 
 * Input renderer
 * 
 * Supported
 *  - sender
 *  - input
 * 
 * Not supported
 *  - message
 *  - radio
 *  - checkbox
 *  - select
 *  - file_upload
 *  - custom_content
 *  - collapse
 */
class RenderInput
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $field;

    /**
     * @var array
     */
    public $user;

    /**
     * @var array
     */
    public $options;

    /**
     * @var string
     */
    public $inputId;

    /**
     * @var array
     */
    public $required = [
        'span' => null,
        'required' => null
    ];

    /**
     * @var array
     */
    public $numbers = [
        'min' => null,
        'max' => null,
        'step' => null
    ];

    /**
     * @var bool
     */
    public $inputGroup = false;

    /**
     * @param string $type Input type
     * @param string $name Input name/id
     * @param array $fieldArray Input field data
     * @param array $userArray Input user data, checks if values has been input
     * @param array $options Optional params
     */
    public function __construct(string $type, string $name, array $fieldArray, array $userArray = [], array $options = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->field = $fieldArray;
        $this->user = $userArray;
        $this->options = $options;
        
        // Set the input id
        $this->inputId = 'values[' . uniqid() . '][' . $this->name . ']';

        // Checks if field is required
        if ($this->field['required_fields']) {
            if (in_array('address', $this->field['required_fields'])) {
                $this->field['required_fields'] = array_merge(
                    $this->field['required_fields'], 
                    ['street_address', 'postal_code', 'city']
                );
            }
            
            if (in_array($this->name, $this->field['required_fields'])) {
                $this->required = [
                    'span' => '<span class="text-danger">*</span>',
                    'required' => 'required'
                ];
            }
        }

        // Add conditional markup for input group
        if ($this->options['googleGeocoding']) {
            $this->inputGroup = true;
        }
    }

    /**
     * Return output
     * 
     * @return string The input markup
     */
    public function __toString() : string
    {
        return $this->input();
    }

    /**
     * Outputs the input field
     * 
     * @return string The input markup
     */
    public function input() : string
    {
        $html = '';

        // Label
        $html .= '<label for="' . $this->inputId . '">';
        $html .= $this->field['labels'][$this->name] . $this->required['span'];
        $html .= '</label>';

        // Additional markup for input group
        if ($this->inputGroup) {
            $html .= '<div class="input-group">';
        }

        // Format date numbers
        if ($this->type == 'date') {
            $this->numbers['min'] = SanitizeData::formatDate($this->field['min_value']);
            $this->numbers['max'] = SanitizeData::formatDate($this->field['max_value']);
        }

        // Add min|max|step
        if (in_array($this->type, ['number', 'range'])) {
            if (!empty(trim($this->field['min_value']))) {
                $this->numbers['min'] = trim($this->field['min_value']);
            }

            if (!empty(trim($this->field['max_value']))) {
                $this->numbers['max'] = trim($this->field['max_value']);
            }

            if (!empty(trim($this->field['step']))) {
                $this->numbers['step'] = trim($this->field['step']);
            }
        }

        // Add the markup
        if ($this->numbers['min'] || $this->numbers['max'] || $this->numbers['step']) {
            $numberOutput = '';

            foreach ($this->numbers as $key => $value) {
                if (isset($value)) {
                    $numberOutput .= ' ' . $key . '="' . $value . '"';
                }
            }
        }

        // The input field
        $html .= '<input ';
        $html .= 'type="' . $this->type . '" ';
        $html .= 'name="' . $this->inputId . '" ';
        $html .= 'id="' . $this->inputId . '" ';
        $html .= 'value="' . esc_html($this->user[$this->inputId]) . '" ';
        $html .= $this->required['required'] . $numberOutput;
        $html .= '>';

        // Add Google Geocoding if set in options
        if ($this->options['googleGeocoding']) {
            $html .= '<span class="input-group-addon-btn"><button id="form-get-location" class="btn">';
            $html .= '<i class="pricon pricon-location-pin"></i> ' . _e('Find my location', 'modularity-form-builder');
            $html .= '</button></span>';
        }

        // Additional markup for input group
        if($this->inputGroup) {
            $html .= '</div>';
        }
        
        return $html;
    }
}
