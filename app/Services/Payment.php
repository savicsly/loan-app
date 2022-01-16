<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Payment
{
    protected $apiKey;
    protected $url;

    public function __construct()
    {
        $this->apiKey = config('services.paystack.secret');
        $this->url = config('services.paystack.url');
    }

    public function charge($payload)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->url . '/charge', $payload);

        return json_decode($response->body());
    }
}
