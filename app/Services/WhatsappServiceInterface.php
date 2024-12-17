<?php
namespace App\Services;

interface WhatsappServiceInterface
{
    public function send(string $message, string $phone, array $options = []): mixed;
    public function verifyIsValidNumber(string $phone): bool;
}
