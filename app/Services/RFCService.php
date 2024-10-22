<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RFCService {
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
        ]);

        $this->apiKey = env('RFC_API_KEY');
    }

    public function getUserInfoByRFC($rfc)
    {
        try {
            $response = $this->client->request('POST', 'https://3.129.253.159/api/RFC/consulta_rfc', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'text/plain',
                ],
                'json' => [
                    'apikey' => $this->apiKey,  // You should pass the key here
                    'rfc' => $rfc,              // and the RFC here
                ]
            ]);            

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle errors as needed
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            } else {
                return [
                    'error' => true,
                    'message' => $e->getMessage(),
                ];
            }
        }
    }

}