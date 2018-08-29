<?php

namespace Pixelarbeit\CF7WeClapp\Config;



class Config
{
    public $formId = null;



    public function __construct() {}


    public static function getOptions($formId)
    {
        $data = get_post_meta($formId, '_weclapp_options', true);
        return is_array($data) ? $data : [];
    }



    public static function saveOptions($formId, $options)
    {
        return update_post_meta($formId, '_weclapp_options', $options);
    }



    public static function getFieldMapping($formId)
    {
        $data = get_post_meta($formId, '_weclapp_field_mapping', true);
        return is_array($data) ? $data : [];
    }



    public static function saveFieldMapping($formId, $mapping)
    {
        return update_post_meta($formId, '_weclapp_field_mapping', $mapping);
    }
    
    
    
    public static function getOptionMapping($formId)
    {
        $data = get_post_meta($formId, '_weclapp_option_mapping', true);
        return is_array($data) ? $data : [];
    }



    public static function saveOptionMapping($formId, $mapping)
    {
        return update_post_meta($formId, '_weclapp_option_mapping', $mapping);
    }


    public static function deleteConfig($formId)
    {
        delete_post_meta($formId, '_weclapp_options_mapping');
        delete_post_meta($formId, '_weclapp_field_mapping');
        delete_post_meta($formId, '_weclapp_option_mapping');
    }
}
