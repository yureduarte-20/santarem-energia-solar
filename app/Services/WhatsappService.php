<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class WhatsappService implements WhatsappServiceInterface
{
    private $url = 'https://api.z-api.io/instances/{ZAPP_INSTANCE}/token/{ZAPP_TOKEN}/send-text';
    public function send(string $message, string $phone, array $options = []): mixed
    {
        $phone = str($phone)->replace(['-', '(', ')', '.'], '')->toString();
        throw_if(!$this->verifyIsValidNumber($phone), Exception::class, 'Número Inválido');
        $phone = str($phone)->prepend('55')->toString();
        $response = Http::withHeader('Client-Token', config('app.ZAPP_VERIFICATION_CODE'))
            ->post($this->prepareUrl(), compact('message', 'phone'));
        return (object) [
            'success' => $response->status() < 300,
            'response_status' => $response->status(),
            'body' => (object) $response->json(null, [])
        ];
    }
    protected function prepareUrl(): string
    {
        return str($this->url)
            ->replace('{ZAPP_INSTANCE}', config('app.ZAPP_INSTANCE'))
            ->replace('{ZAPP_TOKEN}', config('app.ZAPP_TOKEN'))->toString();
    }
    public function verifyIsValidNumber(string $phone): bool
    {
        $pattern = '#^[0-9]{11}$#';
        $matches = [];
        preg_match($pattern, $phone, $matches);
        return count($matches) > 0;
    }
}
