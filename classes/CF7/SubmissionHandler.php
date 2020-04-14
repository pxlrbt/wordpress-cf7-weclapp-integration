<?php

namespace Pixelarbeit\CF7WeClapp\CF7;

use Exception;
use Pixelarbeit\WeClapp\Api as WeClappApi;
use Pixelarbeit\CF7WeClapp\Config\Config;

use pxlrbt\CF7WeClapp\Vendor\pxlrbt\WordpressNotifier\Notifier;
use pxlrbt\CF7WeClapp\Vendor\pxlrbt\WordpressNotifier\Notification;
use pxlrbt\CF7WeClapp\Vendor\Monolog\Logger;
use pxlrbt\CF7WeClapp\Vendor\Monolog\Handler\StreamHandler;
use WPCF7_ContactForm;
use WPCF7_Submission;


class SubmissionHandler
{
	public function __construct(WeClappApi $api)
	{
        $this->notifier = new Notifier();

        $this->logger = new Logger('cf7-weclapp');
        $this->logger->pushHandler(new StreamHandler(WP_CONTENT_DIR . '/cf7-weclapp.log'));

        $this->api = $api;
	}



    public function handleForm(WPCF7_ContactForm $form)
    {
        $this->form = $form;
        $this->options = Config::getOptions($form->id());

        if (isset($this->options['active']) == false || $this->options['active'] == false) {
            return;
        }

        $wcData = $this->getWeClappData($form);

        if (empty($wcData)) {
            return;
        }

        try {
            if (!empty($wcData['email'])) {
                $contact = $this->getContactByEmail($wcData['email']);
            }

            $result = isset($contact)
                ? $this->updateContact($contact->id, $wcData)
                : $this->createContact($wcData);
        } catch (Exception $e) {
            $this->notifier->dispatch(
                Notification::create('Beim Übertragen der Daten an WeClapp ist ein Fehler aufgetreten. Details siehe Log.')
                    ->id('cf7weclapp.error.submission')
                    ->type('error')
                    ->persistent(true)
                    ->dismissible(true)
            );

            $this->logger->error($e->getMessage(), compact('wcData'));
        }

        if (isset($result->error)) {
            $this->notifier->dispatch(
                Notification::create('Beim Übertragen der Daten an WeClapp ist ein Fehler aufgetreten. Details siehe Log.')
                    ->id('cf7weclapp.error.submission')
                    ->type('error')
                    ->persistent(true)
                    ->dismissible(true)
            );
            $this->logger->error($result->error, compact('wcData'));
        }
    }



    private function getCF7FormData()
    {
        $submission = WPCF7_Submission::get_instance();

        if (isset($submission) == false) {
            return null;
        }

        return $submission->get_posted_data();
    }



    private function getWeClappData($form)
    {
        $weClappData = [];
        $formData = $this->getCF7FormData();

        $fieldMapping = Config::getFieldMapping($form->id());
        $optionMapping = Config::getOptionMapping($form->id());


        foreach ($formData as $cf7Name => $cf7Value) {


            if (array_key_exists($cf7Name, $fieldMapping) == false) {
                continue;
            }

            $weClappNames = $fieldMapping[$cf7Name];

            // Handle radio buttons
            if (is_array($cf7Value)) {
                $cf7Value = $cf7Value[0];
            }

            foreach ($weClappNames as $weClappName) {
                if (array_key_exists($weClappName, $optionMapping)) {
                    $cf7Value = isset($optionMapping[$weClappName][$cf7Value])
                        ? $optionMapping[$weClappName][$cf7Value]
                        : null;
                }


                $this->setArrayValueByMultidimensionalKey($weClappData, $weClappName, $cf7Value);
            }

        }

        if (!isset($weClappData['partyType'])) {
            $weClappData['partyType'] = isset($this->options['partyType'])
                ? $this->options['partyType']
                : 'PERSON';
        }

        return $weClappData;
    }


    private function setArrayValueByMultidimensionalKey(&$array, $key, $value)
    {
        $reference = &$array;
        $keys = explode('.', $key);

        foreach ($keys as $key) {
            if (!array_key_exists($key, $reference)) {
                $reference[$key] = [];
            }

            $reference = &$reference[$key];
        }

        $reference = $value;
    }



    public function getContactByEmail($email)
    {
        $type = isset($this->options['type']) ?  $this->options['type'] : 'contact';

        $url = $this->api->buildUrl($type . '?properties=id&email-eq=' . $email);
        $resp = $this->api->request($url);
        return count($resp->result) > 0 ? $resp->result[0] : null;
    }



    public function updateContact($id, $data)
    {
        $type = isset($this->options['type']) ?  $this->options['type'] : 'contact';

        $url = $this->api->buildUrl($type . '/id/' . $id);
        $result = $this->api->request($url, 'PUT', $data);

        return $result;
    }


    public function createContact($data)
    {
        $type = isset($this->options['type']) ?  $this->options['type'] : 'contact';

        $url = $this->api->buildUrl($type);
        $result = $this->api->request($url, 'POST', $data);

        return $result;
    }
}
