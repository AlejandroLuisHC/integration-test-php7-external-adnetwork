<?php

class RequestClass
{
    protected $url;

    public function __construct($p_url)
    {
        $this->url = $p_url;
    }

    public function Get()
    {
        // Create a GET request with the request content
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);

        // Send the request and get the response
        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("Failed request: " . curl_error($curl));
        }

        $http_code   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header      = substr($response, 0, $header_size);
        $body        = substr($response, $header_size);

        return array(
            'http_code' => $http_code, 
            'header'    => $header,
            'body'      => $body
        );
    }
}