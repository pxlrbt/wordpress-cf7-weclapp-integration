<?php

namespace Pixelarbeit\CF7WeClapp;

use Pixelarbeit\Wordpress\SettingsPage\SettingsPage;
use Pixelarbeit\CF7WeClapp\Config\Config;
use Pixelarbeit\CF7WeClapp\Config\FormConfigController;



class Admin
{
    public static $instance;
    public $currentForm = null;



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
        $this->createSettingsPage();
        
        $controller = FormConfigController::getInstance();
        $controller->init();        
	}



    /**
     * Create a settings page for config
     */
    private function createSettingsPage()
    {
        $page = new SettingsPage('cf7-weclapp', 'CF7 to WeClapp');

        $page->addField('token', 'API Token');        
        $page->addField('tenant', 'Mandanten Code');                
    }
}
