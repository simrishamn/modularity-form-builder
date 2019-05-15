<?php
declare(strict_types=1);

namespace ModularityFormBuilder\Helper;

use Generator;

/**
 * Displays form data
 * 
 * Support for deprecated data setters
 */
class FormData
{
    /**
     * @var string
     */
    public $rendered;

    /**
     * @var ModularityFormBuilder\Entity\PostType
     */
    private $PostType;

    /**
     * @var int
     */
    public $moduleId;

    /**
     * @var bool
     */
    public $excludedFront;

    /**
     * @param array $data The data
     * @param array $deprecated Deprecated data
     * @param array $params Additional parameters
     */
    public function __construct(array $data = null, array $deprecated = null, array $params = null)
    {
        $this->PostType = $params['PostType'];
        $this->moduleId = $params['moduleId'];
        $this->excludedFront = $params['excludedFront'];

        if ($data) {
            $this->rendered = $this->renderData($data['labels'], $data['values']);
        }

        if ($deprecated) {
            $this->rendered .= $this->renderDeprecated($deprecated, $params);
        }
    }

    /**
     * Return output
     * 
     * @return string The form data
     */
    public function __toString() : string
    {
        return $this->rendered;
    }

    /**
     * Generates label and value pairs
     * 
     * @param array $labels Labels
     * @param array $values Values
     */
    public function getData($labels, $values) : Generator
    {
        if (!$values) {
            return;
        }

        foreach ($values as $items) {
            $filtered = array_filter($items);

            foreach ($filtered as $key => $value) {
                $values = is_array($value) ? array_filter($value) : $value;

                yield [$labels[$key] ?? '', [$values]];
            }
        }
    }

    /**
     * Renders markup for data
     * 
     * @param array $labels Labels
     * @param array $values Values
     */
    public function renderData($labels, $values) : string
    {
        $html = '';

        foreach ($this->getData($labels, $values) as [$label, $value]) {
            $html .= '<p>';
            $html .= '<strong>' . $label . '</strong><br />';
            $html .= $this->recursive($value);
            $html .= '</p>';
        }

        return $html;
    }

    /**
     * Generates label and value pairs
     * 
     * Deprecated data, is still used for certain types
     * 
     * @param array $labels Labels
     * @param array $values Values
     */
    public function getDeprecated($data, $params) : Generator
    {
        if (!$data) {
            return;
        }

        foreach ($data as $item) {
            $fileUpload = false;
			
            if (
                empty($item['value']) || 
                (isset($params['excludedFront']) && in_array($item['acf_fc_layout'], $params['excludedFront']))
             ) {
                continue;
            }

            if ($item['acf_fc_layout'] == 'file_upload') {
                $fileUpload = true;
            }
            
            $values = is_array($item['value']) ? array_filter($item['value']) : $item['value'];

            yield [$item['label'] ?? '', [$values], $fileUpload];
        }
    }

    /**
     * Renders markup for data
     * 
     * Deprecated data, is still used for certain types
     * 
     * @param array $labels Labels
     * @param array $values Values
     */
    public function renderDeprecated($data, $params) : string
    {
        $html = '';

        foreach ($this->getDeprecated($data, $params) as [$label, $value, $fileUpload]) {
            if ($fileUpload) {
                $uploadFolder = wp_upload_dir()['baseurl'] . '/modularity-form-builder/';

                $value = $value[0];

                $html .= '<strong>' . $label . '</strong><br />';

                foreach ($value as $file) {
                    // Get path of file
                    $filePath = $uploadFolder . basename($file);
                    $filePath = $this->PostType->getDownloadLink($filePath, $this->moduleId);

                    // Get filename
                    $fileName = basename($file);

                    // Print link
                    if($filePath) {
                        $html .= '<a href="' . $filePath . '" class="link-item link d-block" target="_blank">' . $fileName . '</a>';
                    } elseif($fileName) {
                        $html .= '<span class="link-item link d-block">' . $fileName . ' ('. $translation['removed_file'].')</span>';
                    } else {
                        $html .= '<span class="link-item link d-block">'. $translation['unknown_file'].'</span>';
                    }
                }
            } else {
                $html .= '<p>';
                $html .= '<strong>' . $label . '</strong><br />';
                $html .= $this->recursive($value);
                $html .= '</p>';
            }
        }

        return $html;
    }

    /**
     * Recursive function for data handling
     * 
     * @param array $arr The array to search
     * 
     * @return string|array String of values or array to be searched
     */
    public function recursive($arr)
    {
        $values = [];  

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                return $this->recursive($value);
            } else {
                $values[] = $value;
            }
        }

        return join('<br />', $values); 
    } 
}
