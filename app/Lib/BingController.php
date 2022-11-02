<?php

namespace App\Lib;

use Config;

class BingController {

    private $apiKey;
    private $baseURL;
    private $searchEndpoint;

    function getApiKey() {
        return $this->apiKey;
    }

    function getBaseURL() {
        return $this->baseURL;
    }

    function setApiKey($apiKey): void {
        $this->apiKey = $apiKey;
    }

    function setBaseURL($baseURL): void {
        $this->baseURL = $baseURL;
    }

    function getSearchEndpoint() {
        return $this->searchEndpoint;
    }

    function setSearchEndpoint($searchEndpoint): void {
        $this->searchEndpoint = $searchEndpoint;
    }

    public function __construct() {
        $this->apiKey = Config('services.bing.api_key');
        $this->baseURL = "https://api.bing.microsoft.com/";
    }

    public function test() {
//        var_dump($this->getApiKey()); // 3434;

        $query = "beyonce";

        $count = $this->getBingResultsCount($query);
        var_dump($count);
        exit;
    }

    public function getBingResultsCount($query) {
//      $query = '"' . "Tiesto" . '"';
        $query = '"' . $query . '"';
        $endpoint = $this->getBaseURL() . 'v7.0/search';
        $res = $this->BingWebSearch($endpoint, $this->getApiKey(), $query);

        if (!array_key_exists('webPages', $res)) { // got 0 results on bing
            return 0;
        } else if ($res && isset($res['webPages']['totalEstimatedMatches'])) {
            return (int) $res['webPages']['totalEstimatedMatches'];
        }

        return 0;
    }

    function BingWebSearch($url, $key, $query) {
        /* Prepare the HTTP request.
         * NOTE: Use the key 'http' even if you are making an HTTPS request.
         * See: http://php.net/manual/en/function.stream-context-create.php.
         */
        $headers = "Ocp-Apim-Subscription-Key: $key\r\n";
        $options = array('http' => array(
                'header' => $headers,
                'method' => 'GET'));

        // Perform the request and get a JSON response.
        $context = stream_context_create($options);
        $result = file_get_contents($url . "?q=" . urlencode($query), false, $context);

        // Extract Bing HTTP headers.
//        $headers = array();
//        foreach ($http_response_header as $k => $v) {
//            $h = explode(":", $v, 2);
//            if (isset($h[1]))
//                if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
//                    $headers[trim($h[0])] = trim($h[1]);
//        }

        $res = json_decode($result, true);
        return $res;
//        return array($headers, $result);
    }

}
