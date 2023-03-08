<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/Networks/TappxClass.php';

try {
    $appKey               = "pub-1234-android-1234";
    $requestFilePath      = __DIR__ . '/Request.txt';
    $requestContentString = file_get_contents($requestFilePath);

    $test = new Launcher($appKey, $requestContentString);
    $res  = $test->Run();

    //SaveResult($res);
    echo PHP_EOL . PHP_EOL . "end" . PHP_EOL . PHP_EOL . PHP_EOL;
} catch (Exception $p_ex) {
    echo PHP_EOL . PHP_EOL . $p_ex->getMessage() . PHP_EOL . PHP_EOL . PHP_EOL;
}

exit(0);


class Launcher
{

    private $m_app_key;
    private $m_request_content;
    private $m_timeout = 400;

    public function __construct($p_app_key, $p_request_content_object)
    {
        $this->m_app_key         = $p_app_key;
        $this->m_request_content = $this->ParseContent($p_request_content_object);
    }
    private function ParseContent($p_content)
    {
        $decodedJson = json_decode($p_content);
        return $decodedJson;
    }

    public function Run()
    {
        $res = [];


        $start = microtime(true);

        $tappx = new TappxClass($this->m_app_key, $this->m_request_content);
        $res["tappx"] = $tappx->run();
        //$res[] = new Network2Class($this->m_app_key, $this->m_request_content)->Run();
        //$res[] = new Network3Class($this->m_app_key, $this->m_request_content)->Run();
        //$res[] = new Network4Class($this->m_app_key, $this->m_request_content)->Run();

        if (((microtime(true) - $start) * 1000) > $this->m_timeout || is_null($this->m_timeout))
            throw new Exception("TEST not valid");

        return $res;
    }
}
