<?php

require_once __DIR__ . '/../utils/RequestClass.php';

abstract class BaseClass
{
    protected $appKey;
    protected $requestContent;

    public function __construct($appKey, $requestContent)
    {
        $this->appKey = $appKey;
        $this->requestContent = $requestContent;
    }

    protected function RequestGet($p_url)
    {
        $request = new RequestClass($p_url);
        $response = $request->Get();
        return $response;
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
