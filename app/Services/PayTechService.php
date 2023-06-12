<?php

namespace App\Services;

use GuzzleHttp\Client;

class PayTechService
{
    protected $client;
    protected $apiKey; // Clé d'API PayTech SN

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('paytech.api_url'),
            'auth' => [
                config('paytech.username'),
                config('paytech.password'),
            ],
        ]);
        $this->apiKey = config('paytech.api_key'); // Récupérer la clé d'API à partir de la configuration
    }

        public function createPayment($data)
        {
            try {
                $response = $this->client->post('https://api.paytech.sn/payment/request-payment', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'amount' => $data['amount'],
                        // Autres données de paiement à inclure
                    ],
                ]);

                $paymentResponse = json_decode($response->getBody(), true);

                return [
                    'success' => true,
                    'redirect_url' => $paymentResponse['redirect_url'],
                ];
            } catch (RequestException $e) {
                // Gérer les erreurs de requête
                return [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

    public function getUser($userId)
    {
        $response = $this->client->get('/users/' . $userId);

        return json_decode($response->getBody(), true);
    }
}
