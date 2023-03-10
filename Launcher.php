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
    private $m_timeout;

    public function __construct($p_app_key, $p_request_content_object)
    {
        $this->m_app_key         = $p_app_key;
        $this->m_request_content = $this->ParseContent($p_request_content_object);
        $this->m_timeout = $this->m_request_content->timeout;
    }
    private function ParseContent($p_content)
    {
        $decodedJson = json_decode($p_content);
        // Set query params for the request
        $sz       = $requestContent->imp[0]->banner->w . "x" . $requestContent->imp[0]->banner->h;
        $os       = $requestContent->device->os;
        $ip       = $requestContent->device->ip;
        $source   = $requestContet->app ? "app" : "web";
        $ab       = $requestContent->app->bundle;
        $aid      = $requestContent->device->ifa;
        if (in_array(3, $requestContent->imp->banner->api)) {
            $mraid = 1;
        } else if (in_array(5, $requestContent->imp->banner->api)) {
            $mraid = 2;
        } else {
            $mraid = 0; 
        };
        $ua       = $requestContent->device->ua;
        $cb       = uniqid();
        $timeout  = $requestContent->tmax;
        $an       = $requestContent->app->name;
        $url      = $requestContent->app->storeurl;
        return array(
            "sz" => $sz,
            "os" => $os,
            "ip" => $ip,
            "source" => $source,
            "ab" => $ab,
            "aid" => $aid,
            "mraid" => $mraid,
            "ua" => $ua,
            "cb" => $cb,
            "timeout" => $timeout,
            "an" => $an,
            "url" => $url
        );
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
