<?php

abstract class BaseClass
{
    protected $appKey;
    protected $requestContent;

    // Query params
    protected $sz;
    protected $os;
    protected $ip;
    protected $source;
    protected $ab;
    protected $aid;
    protected $mraid;
    protected $ua;
    protected $cb;
    protected $timeout;
    protected $an;
    protected $url;

    public function __construct($appKey, $requestContent)
    {
        $this->appKey = $appKey;
        $this->requestContent = $requestContent;

        // Set query params for the request
        $this->sz       = $requestContent->imp[0]->banner->w . "x" . $requestContent->imp[0]->banner->h;
        $this->os       = $requestContent->device->os;
        $this->ip       = $requestContent->device->ip;
        $this->source   = "app";
        $this->ab       = $requestContent->app->bundle;
        $this->aid      = $requestContent->device->ifa;
        $this->mraid    = "1";
        $this->ua       = $requestContent->device->ua;
        $this->cb       = uniqid();
        $this->timeout  = "400";
        $this->an       = $requestContent->app->name;
        $this->url      = $requestContent->app->storeurl;
    }

    protected function StoreResponse($p_http_code, $p_header, $p_body)
    {
        $test = 0;
        $error = 0;
        $errorReason = "";
        $ad = "";

        if ($p_http_code === 204 || $p_http_code === 400) {
            $error = 1;
            $errorReason = null;
            if (strpos($p_header, "X-Error-Reason") !== false) {
                $errorReason = trim(explode("X-Error-Reason:", $p_header)[1]);
            }
        } else {
            $test = strpos($p_header, "X-Test-Ad: No") === false ? 1 : 0;
            print_r($p_header);
            $ad = $p_body;
        }

        // Save the response in the Output folder
        $outputPath = __DIR__ . "/../Output/" . date("dmY") . "-" . time() . ".json";

        $storeOutput = fopen($outputPath, "x");
        if ($storeOutput === false) {
            throw new Exception("Failed to open file: " . $outputPath);
        }

        $message = json_encode(array(
            "status"       => $p_http_code,
            "test"         => $test,
            "error"        => $error,
            "error_reason" => $errorReason,
            "ad"           => $ad
        ));

        fwrite($storeOutput, $message);
        fclose($storeOutput);
        return json_decode($message);
    }
}
