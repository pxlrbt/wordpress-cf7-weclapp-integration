<?php

namespace Pixelarbeit\WeClapp;



use Pixelarbeit\Http\JsonClient;



class Api
{
    private $tenant;
    private $token;
    private $client;



    public function __construct($tenant, $token)
    {
        $this->tenant = $tenant;
        $this->token = $token;
        $this->client = new JsonClient();
    }


    public function request($url, $method = "GET", $data = null)
    {
        $headers = ['AuthenticationToken: ' . $this->token];
        $response = $this->client->request($method, $url, $data, $headers);
        return $response[1];
    }


    public function buildUrl($endpoint)
    {
        return 'https://' . $this->tenant . '.weclapp.com/webapp/api/v1/' . $endpoint;
    }
}