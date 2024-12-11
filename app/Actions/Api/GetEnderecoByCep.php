<?php
namespace App\Actions\Api;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetEnderecoByCep
{
    private $url = 'https://viacep.com.br/ws/{cep}/json/';
    public function getByCep(string $cep)
    {
        $cep = str($cep)->replace(['/', '-', '.', '\\'], '')->trim();
        $url = str($this->url)->replace('{cep}', $cep);
        if(Cache::has("cep:$cep")){
            return Cache::get("cep:$cep");
        }
        $response = Http::get($url);
        if ($response->getStatusCode() < 300) {
            $body = $response->json();
            if (isset($body['erro']))
                return null;

            Cache::put("cep:$cep", $body);
            return $body;
        }
        return null;
    }
}
