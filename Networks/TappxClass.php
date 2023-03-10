<?php

require_once __DIR__ . "/BaseClass.php";

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
        $url .= "&sz="      . urlencode($this->requestContent['sz']);
        $url .= "&os="      . urlencode($this->requestContent['os']);
        $url .= "&ip="      . urlencode($this->requestContent['ip']);
        $url .= "&source="  . urlencode($this->requestContent['source']);
        $url .= "&ab="      . urlencode($this->requestContent['ab']);
        $url .= "&aid="     . urlencode($this->requestContent['aid']);
        $url .= "&mraid="   . urlencode($this->requestContent['mraid']);
        $url .= "&ua="      . urlencode($this->requestContent['ua']);
        $url .= "&cb="      . urlencode($this->requestContent['cb']);
        $url .= "&timeout=" . urlencode($this->requestContent['timeout']);
        $url .= "&an="      . urlencode($this->requestContent['an']);
        $url .= "&url="     . urlencode($this->requestContent['url']);

        // Send the request to the API
        $data = $this->RequestGet($url);

        echo "Tappx API returned HTTP code " . $data['http_code'];
        $storedMsg = $this->StoreResponse($data['http_code'], $data['header'], $data['body']);

        return $storedMsg;
    }
}
