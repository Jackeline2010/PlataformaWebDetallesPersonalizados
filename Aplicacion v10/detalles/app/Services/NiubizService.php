<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class NiubizService
{
    protected string $env;
    protected ?string $baseUrl;
    protected ?string $merchantId;
    protected ?string $user;
    protected ?string $password;
    protected ?string $apiKey;
    protected string $currency;
    protected string $channel;

    public function __construct()
    {
        $this->env = config('niubiz.env', 'sandbox');
        $this->baseUrl = config("niubiz.{$this->env}.base_url");

        $this->merchantId = config('niubiz.merchant_id');
        $this->user = config('niubiz.user');
        $this->password = config('niubiz.password');
        $this->apiKey = config('niubiz.api_key');

        $this->currency = config('niubiz.currency', 'USD');
        $this->channel = config('niubiz.channel', 'web');
    }

    public function getAccessToken(): string
    {
        $this->validateConfig();

        $response = Http::withoutVerifying()
            ->withBasicAuth($this->user, $this->password)
            ->get($this->baseUrl . '/api.security/v1/security');

        if (!$response->successful()) {
            throw new Exception('Error token Niubiz: ' . $response->body());
        }

        return trim($response->body());
    }

    public function createSession(float $amount, string $purchaseNumber): array
    {
        $token = $this->getAccessToken();

        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
            ])
            ->post($this->baseUrl . "/api.ecommerce/v2/ecommerce/token/session/{$this->merchantId}", [
                'channel' => $this->channel,
                'amount' => (float) number_format($amount, 2, '.', ''),
                'antifraud' => [
                    'clientIp' => request()->ip(),
                    'merchantDefineData' => [
                        'MDD4' => auth()->user()->email ?? 'cliente@demo.com',
                        'MDD32' => (string) (auth()->id() ?? 'CLIENTE001'),
                        'MDD75' => 'Registrado',
                        'MDD77' => 30,
                    ],
                ],
                'dataMap' => [
                    'cardholderCity' => 'Loja',
                    'cardholderCountry' => 'EC',
                    'cardholderAddress' => 'Direccion Cliente',
                    'cardholderPostalCode' => '110111',
                    'cardholderState' => 'LOJ',
                    'cardholderPhoneNumber' => '0999999999',
                ],
            ]);

        if (!$response->successful()) {
            throw new Exception('Error sesión Niubiz: ' . $response->body());
        }

        return [
            'access_token' => $token,
            'session' => $response->json(),
        ];
    }

    public function authorizePayment(
        string $transactionToken,
        float $amount,
        string $purchaseNumber
    ): array {
        $token = $this->getAccessToken();

        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
            ])
            ->post($this->baseUrl . "/api.authorization/v3/authorization/ecommerce/{$this->merchantId}", [
                'channel' => $this->channel,
                'captureType' => 'manual',
                'countable' => true,
                'order' => [
                    'tokenId' => $transactionToken,
                    'purchaseNumber' => $purchaseNumber,
                    'amount' => (float) number_format($amount, 2, '.', ''),
                    'currency' => $this->currency,
                ],
                'dataMap' => [
                    'urlAddress' => config('app.url'),
                    'serviceLocationCityName' => 'Loja',
                    'serviceLocationCountrySubdivisionCode' => 'LOJ',
                    'serviceLocationCountryCode' => 'ECU',
                    'serviceLocationPostalCode' => '110111',
                ],
            ]);

        if (!$response->successful()) {
            throw new Exception('Error autorización Niubiz: ' . $response->body());
        }

        return $response->json();
    }

    public function getMerchantId(): string
    {
        return (string) $this->merchantId;
    }

    public function getApiKey(): string
    {
        return (string) $this->apiKey;
    }

    public function getJsUrl(): string
    {
        return (string) config("niubiz.{$this->env}.js_url");
    }

    private function validateConfig(): void
    {
        if (!$this->baseUrl || !$this->merchantId || !$this->user || !$this->password) {
            throw new Exception('Faltan credenciales de Niubiz en el archivo .env.');
        }
    }
}
