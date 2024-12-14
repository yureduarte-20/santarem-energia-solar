<?php

namespace Database\Seeders;

use App\Models\MetodoPagamento;
use Illuminate\Database\Seeder;

class MetodoPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MetodoPagamento::createOrFirst(['nome' => 'Pix']);
        MetodoPagamento::createOrFirst(['nome' => 'Crediário']);
        MetodoPagamento::createOrFirst(['nome' => 'Boleto']);
    }
}
