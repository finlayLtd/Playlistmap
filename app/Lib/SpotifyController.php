<?php

namespace App\Lib;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Config;
use Log;

class SpotifyController {

    private $apiKey;
    private $apiSecret;
    private $spotifyAccessToken;
    private $spotifyApiTokenURL;
    private $spotifyBaseEndpoint;
    private $apiKeys;
    private $usedAPIKeys;

    function getApiKey() {
        return $this->apiKey;
    }

    function getApiSecret() {
        return $this->apiSecret;
    }

    function getSpotifyBaseEndpoint() {
        return $this->spotifyBaseEndpoint;
    }

    function setApiKey($apiKey): void {
        $this->apiKey = $apiKey;
    }

    function setApiSecret($apiSecret): void {
        $this->apiSecret = $apiSecret;
    }

    function setSpotifyBaseEndpoint($spotifyBaseEndpoint): void {
        $this->spotifyBaseEndpoint = $spotifyBaseEndpoint;
    }

    function getSpotifyApiTokenURL() {
        return $this->spotifyApiTokenURL;
    }

    function setSpotifyApiTokenURL($spotifyApiTokenURL): void {
        $this->spotifyApiTokenURL = $spotifyApiTokenURL;
    }

    function getApiKeys() {
        return $this->apiKeys;
    }

    function setApiKeys($apiKeys): void {
        $this->apiKeys = $apiKeys;
    }

    function getUsedAPIKeys() {
        return $this->usedAPIKeys;
    }

    function setUsedAPIKeys($usedAPIKeys): void {
        $this->usedAPIKeys = $usedAPIKeys;
    }

    function getSpotifyAccessToken() {
        return $this->spotifyAccessToken;
    }

    function setSpotifyAccessToken($spotifyAccessToken): void {
        $this->spotifyAccessToken = $spotifyAccessToken;
    }

    function __construct() {
//        echo "<pre>";
        $this->apiKey = false;
        $this->apiSecret = false;
        $this->initAPIKeys();
        
//        var_dump($this->getApiKeys());

        $this->spotifyApiTokenURL = "https://accounts.spotify.com/api/token";
        $this->spotifyBaseEndpoint = "https://api.spotify.com/v1/";
        
        $this->generateAccessToken();
    }

    private function initAPIKeys() {
        $apiKeys = Config('services.spotify');
        $this->setApiKeys($apiKeys);
        return;
    }

    private function changeAPIKey() {
        $apiKeys = $this->getApiKeys();
        if (count($apiKeys) === 0) {
            Log::channel('spotify_api')->info('All API keys are blocked - aborting');
            return false;
        }
        // $rand = 1;
        $rand = rand(1, count($apiKeys));
        $randomAPIKey = $apiKeys['api_key' . $rand];
        $this->setApiKey($randomAPIKey['client_id' . $rand]);
        $this->setApiSecret($randomAPIKey['client_secret' . $rand]);

        
        
        unset($apiKeys['api_key' . $rand]);
        $this->setApiKeys($apiKeys);
        return true;
    }

    public function getTestAccessToken() {
        
        $apiKey = "77ff937338ae461084ba3e32a0c5781f";
        $secret = "19a3ef804ac947e5a0a056bfe5f62604";
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($this->getSpotifyApiTokenURL(), [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($apiKey . ':' . $secret),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (RequestException $e) {
            var_dump('Spotify Exceptionn');
            exit;
            //throw new SpotifyAuthException($message, $status, $errorResponse);
        }
//        Log::channel('spotify_api')->info('Successfully generated new access token');
        $body = json_decode((string) $response->getBody());


        $accessToken = $body->access_token;
        return $accessToken;
        var_dump('access_token');
        var_dump($accessToken);
        exit;
    }
    
    public function checkSpotifyStatus(){
        echo "<pre>";
        var_dump("checkSpotifyStatus");
        $accessToken = $this->getTestAccessToken();
        $uri = "playlists/67qwiP4iui5VlSpxyxi2Ck";
         $response = Http::withToken($accessToken)->get($this->getSpotifyBaseEndpoint() . $uri)->json();
         
         var_dump($response);
         exit;
         
    }

    private function generateAccessToken() {
        if (Cache::has('spotifyAccessToken')) {
            $this->setSpotifyAccessToken(Cache::get('spotifyAccessToken'));
            return;
        }
        if (!$this->changeAPIKey()) {
            // abort - no more api keys left
            var_dump('All keys got API Rate Limit');
            Log::channel('spotify_api')->info('All keys got API Rate Limit');
            return false;
        }

        try {
            Log::channel('spotify_api')->info('Generating new spotify access token');
            $client = new \GuzzleHttp\Client();
            $response = $client->post($this->getSpotifyApiTokenURL(), [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($this->getApiKey() . ':' . $this->getApiSecret()),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (RequestException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents());
            $status = $e->getCode();
            $message = $errorResponse->error;
            var_dump('Spotify Exceptionn');
            var_dump($errorResponse);
            var_dump($status);
            var_dump($message);
            exit;
            //throw new SpotifyAuthException($message, $status, $errorResponse);
        }
        Log::channel('spotify_api')->info('Successfully generated new access token');
        $body = json_decode((string) $response->getBody());


        $accessToken = $body->access_token;
       
        
        $this->setSpotifyAccessToken($accessToken);
        Cache::remember('spotifyAccessToken', $body->expires_in, function () use ($body) {
            return $body->access_token;
//            return true;
//            return $body->access_token;
        });

        return true;
    }

    public function doSpotifyRequest($uri, $params = false) {
//        var_dump('spotify request');
//        $starttime = microtime(true);
        $queryString = $this->convertParamsToQueryString($params);
//        var_dump("URL= " . $this->getSpotifyBaseEndpoint() . $uri . $queryString);
//        echo "<pre>";
        try {
            $response = Http::withToken($this->getSpotifyAccessToken())->get($this->getSpotifyBaseEndpoint() . $uri . $queryString)->json();
//            $response = Http::withToken($this->getSpotifyAccessToken())->get($this->getSpotifyBaseEndpoint() . $uri . $queryString);
//            var_dump($response->headers());
//            $response = $response->json();
            
            if (array_key_exists('error', $response)) {

                if ($response['error']['status'] === 429) {
                    throw new Exception("API Rate limit");
                } else if ($response['error']['status'] === 404) {
                    return false;
                }
            }
        } catch (\Throwable $ex) {
            Log::channel('spotify_api')->info('Spotify API Rate limit');
            Log::channel('spotify_api')->info('Generating new access token');
            $i = 0;
            while ($i < 10) { // try change spotify 
                $i++;
//                var_dump($i);
                try {
                    Cache::forget('spotifyAccessToken');
//                    var_dump('Generate new key');
                    if (!$this->generateAccessToken()) {
                        return false;
                    }
                    $response = Http::withToken($this->getSpotifyAccessToken())->get($this->getSpotifyBaseEndpoint() . $uri . $queryString)->json();
                    if (array_key_exists('error', $response) && $response['error']['status'] === 429) {
                        continue;
                    }
                } catch (\Throwable $ex) {
                    continue; // generate new access token
                }
            }
            Log::channel('spotify_api')->info('Successfully switched API key');
        }
//        print_r($response);
//        $endtime = microtime(true);
//         $timediff = $endtime - $starttime;
//         var_dump('total time for request: ' . $timediff . ' seconds');
        return $response;
    }

    private function convertParamsToQueryString($params) {
//        var_dump($params);
        if (!$params) {
            return "";
        }
        $queryString = "";
        foreach ($params as $key => $value) {
            if ($queryString === "") {
                $queryString .= "?$key=$value";
            } else {
                $queryString .= "&$key=$value";
            }
        }
//        var_dump($queryString);
        return $queryString;
    }

}
