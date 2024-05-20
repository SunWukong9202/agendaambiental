<?php
// app/Services/TauApiService.php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class 
DipomexService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.tau.com.mx',
            'verify' => false, // -k option in cURL to disable SSL verification
        ]);

        $this->apiKey = env('DIPOMEX_API_KEY'); // Assuming you store your API key in the .env file
    }

    public function getAddressByPostalCode($postalCode)
    {
        try {
            $response = $this->client->request('GET', '/dipomex/v1/codigo_postal', [
                'headers' => [
                    'APIKEY' => $this->apiKey,
                ],
                'query' => [
                    'cp' => $postalCode,
                ],
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
