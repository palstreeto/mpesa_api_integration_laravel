<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortCode;
    protected $passkey;
    protected $env;
    protected $client;

    public function __construct()
    {
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->shortCode = env('MPESA_SHORTCODE');
        $this->passkey = env('MPESA_PASSKEY');
        $this->env = env('MPESA_ENV');
        $this->client = new Client();
    }

    public function getAccessToken()
    {
        $url = $this->env === 'production' ? 
               'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' : 
               'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = $this->client->request('GET', $url, [
            'auth' => [$this->consumerKey, $this->consumerSecret]
        ]);

        return json_decode($response->getBody())->access_token;
    }

    public function stkPush($amount, $phone, $accountReference, $transactionDesc)
    {
        $url = $this->env === 'production' ? 
               'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest' : 
               'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortCode . $this->passkey . $timestamp);

        $accessToken = $this->getAccessToken();

        $response = $this->client->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'BusinessShortCode' => $this->shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => $accountReference,
                'TransactionDesc' => $transactionDesc
            ]
        ]);

        return json_decode($response->getBody());
    }
}
