<?php

namespace Pixelarbeit\CF7WeClapp\Config;

use WPCF7_ContactForm;


class FormConfigController
{
    public static $instance;



    private function __construct() {}



    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }



	public function init()
	{
        add_action('wpcf7_save_contact_form', [$this, 'saveCF7Config'], 10, 1 );
        add_filter('wpcf7_editor_panels', [$this, 'registerEditorPanel'], 10, 1);
    }



    public function registerEditorPanel($panels)
    {
        $panels['weclapp-panel'] = [
            'title' => 'WeClapp',
            'callback' => [$this, 'printEditorPanel']
        ];

        return $panels;
    }


    /* CF7 HELPER FUNCTIONS */
    public function getCurrentForm()
    {
        return WPCF7_ContactForm::get_current();
    }



    public function getCurrentFormId()
    {
        $form = WPCF7_ContactForm::get_current();
        return isset($form) ? $form->id() : null;
    }



    private function getCF7FieldNames()
    {
        $fields = [];
        $tags = $this->getCurrentForm()->scan_form_tags();

        foreach ($tags as $tag) {
            if (in_array($tag['basetype'], ['hidden', 'text', 'select', 'email', 'tel', 'number', 'date', 'textarea', 'radio'])) {
                $fields[] = $tag['name'];
            }
        }

        return $fields;
    }



    private function getCF7FieldOptions()
    {
        $options = [];
        $tags = $this->getCurrentForm()->scan_form_tags();

        foreach ($tags as $tag) {
            if (in_array($tag->basetype, ['select', 'radio'])) {
                $options[$tag->name] = $tag->values;
            }
        }

        return $options;
    }


    /* SAVING FUNCTIONS */
    public function saveCF7Config($form)
    {
        if (count($_POST['wpcf7-weclapp_field']['cf7']) == 0) {
            return;
        }

        $this->saveOptions();
        $this->saveFieldMapping();
        $this->saveOptionMapping();
    }



    private function saveOptions()
    {
        $options = [];

        $options['active'] = isset($_POST['wpcf7-weclapp_options']['active']);

        foreach ($_POST['wpcf7-weclapp_options'] as $optionName => $optionValue) {
            $options[$optionName] = $optionValue;
        }

        Config::saveOptions($this->getCurrentFormId(), $options);
    }



    private function saveFieldMapping()
    {
        $mapping = [];
        for ($i = 0; $i < count($_POST['wpcf7-weclapp_field']['cf7']); $i++) {
            $cf7 = $_POST['wpcf7-weclapp_field']['cf7'][$i];
            $weclapp = $_POST['wpcf7-weclapp_field']['weclapp'][$i];

            if (empty($cf7)) {
                continue;
            }

            $mapping[$cf7][] = $weclapp;
        }

        Config::saveFieldMapping($this->getCurrentFormId(), $mapping);
    }



    private function saveOptionMapping()
    {
        $mapping = [];

        for ($i = 0; $i < count($_POST['wpcf7-weclapp_option']['cf7_field']); $i++) {
            $cf7_field = $_POST['wpcf7-weclapp_option']['cf7_field'][$i];
            $cf7_option = $_POST['wpcf7-weclapp_option']['cf7_option'][$i];
            $weclapp_option = $_POST['wpcf7-weclapp_option']['weclapp_option'][$i];

            $mapping[$cf7_field][$cf7_option] = $weclapp_option;
        }

        Config::saveOptionMapping($this->getCurrentFormId(), $mapping);
    }



    /* PRINTING FUNCTIONS */
    public function printEditorPanel($form)
    {
        $this->options = Config::getOptions($this->getCurrentFormId());
        include __DIR__ . '/../../views/cf7-weclapp-panel.php';
    }



    public function printKeyMappingBox($weClappName)
    {
        $cf7Fields = $this->getCF7FieldNames();
        $mapping = Config::getFieldMapping($this->getCurrentFormId());

        echo '<input type="hidden" name="wpcf7-weclapp_field[weclapp][]" value="' . $weClappName . '">';
        echo '<select name="wpcf7-weclapp_field[cf7][]">';
        echo '<option></option>';

        foreach ($cf7Fields as $cf7Name) {
            $selected = isset($mapping[$cf7Name]) && in_array($weClappName, $mapping[$cf7Name]) ? 'selected' : '';
            echo '<option value="' . $cf7Name . '" ' . $selected . '>' . $cf7Name . '</option>';
        }

        echo '</select>';
    }



    public function printValueMappingBox($weClappName, $weClappValues)
    {

        $options = $this->getCF7FieldOptions();
        $fieldMapping = Config::getFieldMapping($this->getCurrentFormId());
        $optionMapping = Config::getOptionMapping($this->getCurrentFormId());

        $cf7Field = null;

        foreach ($fieldMapping as $cf7Name => $mappedWeClappNames) {

            if (in_array($weClappName, $mappedWeClappNames)) {
                $cf7Field = $cf7Name;
            }
        }

        if ($cf7Field == null) {
            return;
        }

        if (isset($options[$cf7Field]) == false) {
            return;
        }

        echo "<table>";

        foreach ($options[$cf7Field] as $option) {
            echo "<tr>";
            echo '<td><label for="wpcf7-weclapp_option' . $weClappName . '">' . $option . ':</label></td>';
            echo '<td><input type="hidden" name="wpcf7-weclapp_option[cf7_field][]" value="' . $weClappName . '">';
            echo '<input type="hidden" name="wpcf7-weclapp_option[cf7_option][]" value="' . $option . '">';
            echo '<select name="wpcf7-weclapp_option[weclapp_option][]" id="wpcf7-weclapp_option_' . $weClappName . '">';
            echo '<option></option>';

            foreach ($weClappValues as $wcValue) {
                $selected = isset($optionMapping[$weClappName][$option]) && $optionMapping[$weClappName][$option] == $wcValue ? 'selected' : '';
                echo '<option value="' . $wcValue . '" ' . $selected . '>' . $wcValue . '</option>';
            }

            echo '</select></td></tr>';
        }
        echo "</table>";
    }
}
