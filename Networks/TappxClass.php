<?php

require __DIR__ . "/BaseClass.php";

class TappxClass extends BaseClass
{

    public function __construct($p_app_key, $p_request_content_object)
    {
        parent::__construct($p_app_key, $p_request_content_object);
    }

    public function Run()
    {

        // Define the API endpoint URL
        $url = "http://test-ssp.tappx.net/ssp/req.php";

        // Append the required parameters to the URL string
        $url .= "?key="     . urlencode($this->appKey);
        $url .= "&sz="      . urlencode($this->sz);
        $url .= "&os="      . urlencode($this->os);
        $url .= "&ip="      . urlencode($this->ip);
        $url .= "&source="  . urlencode($this->source);
        $url .= "&ab="      . urlencode($this->ab);
        $url .= "&aid="     . urlencode($this->aid);
        $url .= "&mraid="   . urlencode($this->mraid);
        $url .= "&ua="      . urlencode($this->ua);
        $url .= "&cb="      . urlencode($this->cb);
        $url .= "&timeout=" . urlencode($this->timeout);
        $url .= "&an="      . urlencode($this->an);
        $url .= "&url="     . urlencode($this->url);

        // Create a GET request with the request content
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
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

        echo "Tappx API returned HTTP code " . $http_code;
        $res = $this->StoreResponse($http_code, $header, $body);

        return $res;
    }
}
