<?php

namespace Pixelarbeit\CF7WeClapp;

use Pixelarbeit\WeClapp\Api as WeClappApi;
use Pixelarbeit\CF7WeClapp\CF7\SubmissionHandler;
use pxlrbt\CF7WeClapp\Vendor\pxlrbt\WordpressNotifier\Notifier;



class Frontend
{
    private $api;
    private $notifier;
    private $submissionHandler;



	public function __construct()
	{
        $this->notifier = new Notifier();

        $this->addHooks();
        $this->initApi();

        if ($this->api != null) {
            $this->submissionHandler = new SubmissionHandler($this->api);
        }
	}



    public function initApi()
    {
        $token = get_option('cf7-weclapp_token');
        $tenant = get_option('cf7-weclapp_tenant');

        if (empty($token) || empty($tenant)) {
            return $this->notifier->warning('Incomplete configuration.');
        }

        $this->api = new WeClappApi($tenant, $token);
    }



    private function addHooks()
    {
        add_action('wpcf7_mail_sent', [$this, 'onCF7MailSent']);
    }


    public function onCF7MailSent($form) {
        return $this->submissionHandler->handleForm($form);
    }
}
