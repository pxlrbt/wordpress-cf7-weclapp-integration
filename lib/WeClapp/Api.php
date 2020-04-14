<?php

namespace Pixelarbeit\WeClapp;

use pxlrbt\CF7WeClapp\Vendor\GuzzleHttp\Client;

class Api
{
    private $tenant;
    private $token;
    private $client;



    public function __construct($tenant, $token)
    {
        $this->tenant = $tenant;
        $this->token = $token;
        $this->client = new Client();
    }


    public function request($url, $method = "GET", $data = null)
    {
        $headers = ['AuthenticationToken' => $this->token];

        $response = $this->client->request($method, $url, [
            'json' => $data,
            'headers' => $headers
        ]);

        $content = $response->getBody()->getContents();
        $json = json_decode($content);

        if ($json === null) {
            throw new Exception('Invalid JSON response.');
        }

        return $json;
    }


    public function buildUrl($endpoint)
    {
        return 'https://' . $this->tenant . '.weclapp.com/webapp/api/v1/' . $endpoint;
    }
}
