<?php
declare(strict_types=1);

namespace ModularityFormBuilder\Helper;

/**
 * Input renderer
 * 
 * Only support for input types at the moment
 * No support for radio, checkbox, select, textarea
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
                array_merge($this->field['required_fields'], ['street_address', 'postal_code', 'city']);
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

        // Render the input
        $this->input();
    }

    /**
     * Outputs the input field
     * 
     * @return void
     */
    public function input() : void
    {
        // If type is of number type add additional params
        $numbers = [
            'min' => null,
            'max' => null,
            'step' => null
        ];

        $html = '';

        // Label
        $html .= '<label for="' . $this->inputId . '">' . $this->field['labels'][$this->name] . $this->required['span'] . '</label>';

        // Additional markup for input group
        if ($this->inputGroup) {
            $html .= '<div class="input-group">';
        }

        // Format date numbers
        if ($this->type == 'date') {
            $numbers['min'] = SanitizeData::formatDate($this->field['min_value']);
            $numbers['max'] = SanitizeData::formatDate($this->field['max_value']);
        }

        // Add min|max|step
        if (in_array($this->type, ['number', 'range'])) {
            if (!empty(trim($this->field['min_value']))) {
                $numbers['min'] = trim($this->field['min_value']);
            }

            if (!empty(trim($this->field['max_value']))) {
                $numbers['max'] = trim($this->field['max_value']);
            }

            if (!empty(trim($this->field['step']))) {
                $numbers['step'] = trim($this->field['step']);
            }
        }

        // Add the markup
        if ($numbers['min'] || $numbers['max'] || $numbers['step']) {
            $numberOutput = '';

            foreach ($numbers as $key => $value) {
                if (isset($value)) {
                    $numberOutput .= ' ' . $key . '="' . $value . '"';
                }
            }
        }

        // The input field
        $html .= '<input type="' . $this->type . '" name="' . $this->inputId . '" id="' . $this->inputId . '" value="' . $this->user[$this->inputId] . '" ' . $this->required['required'] . $numberOutput . '>';

        // Add Google Geocoding is set in options
        if ($this->options['googleGeocoding']) {
            $html .= '<span class="input-group-addon-btn"><button id="form-get-location" class="btn"><i class="pricon pricon-location-pin"></i> ' . _e('Find my location', 'modularity-form-builder') . '</button></span>';
        }

        // Additional markup for input group
        if($this->inputGroup) {
            $html .= '</div>';
        }
        
        echo $html;
    }
}
