<?php

namespace App\Providers;

use App\Services\WhatsappService;
use App\Services\WhatsappServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
class AppServiceProvider extends ServiceProvider
{
    private function valida_cpf($cpf): bool
    {
        if (strlen($cpf) < 11)
            return false;
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($i = 9; $i < 11; $i++) {
            $j = 0;
            for ($k = 0; $k < $i; $k++) {
                $j += $cpf[$k] * (($i + 1) - $k);
            }
            $j = ((10 * $j) % 11) % 10;
            if ($cpf[$k] != $j) {
                return false;
            }
        }

        return true;
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('cpf', function ($attribute, $value, $parameters, $validator) {
            return $this->valida_cpf($value);
        }, 'O campo :attribute não é um CPF válido.');
        $this->app->bind(WhatsappServiceInterface::class, function (Application $app) {
            return new WhatsappService();
        });
        Str::macro('concat', function(string $str1, string $str2) : string {
            return $str1 . $str2;
        });
        
    }
}
