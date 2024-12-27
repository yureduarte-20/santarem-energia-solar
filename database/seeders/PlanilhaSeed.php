<?php

namespace Database\Seeders;

use App\Enums\TipoRede;
use App\Enums\TipoTelhado;
use App\Models\Cliente;
use App\Models\Pedido;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use Rap2hpoutre\FastExcel\FastExcel;

class PlanilhaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(
            function () {
                $import = (new FastExcel)->import(
                    storage_path('Clientes.xlsx'),
                    function ($line) {
                        $cpf = str($line['CPF'])->replace(['.', '-'], '')->trim();
                        if ($cpf->isEmpty())
                            return;

                        $telefone = $line['TELEFONE'] ? str($line['TELEFONE'])->replace(['(', ')', ' ', '-', '.'], '')
                            ->trim()
                            ->match("#^[0-9]+$#")
                            : null;
                        $telefone?->isEmpty() and $telefone = null;
                        $cliente = Cliente::firstOrCreate(['cpf' => $line['CPF']], [
                            'cpf' => $cpf,
                            'nome' => $line['FINANCIAMENTO'],
                            'telefone' => $telefone
                        ]);
                        $cliente->endereco()->create([
                            'cidade' => $line['CIDADE'] ?? null,
                            'tipo_telhado' => TipoTelhado::fromString($line["TELHADO"]),
                            'uf' => 'PA'
                        ]);



                        $line['PREVISAO DE ENTREGA'] instanceof DateTimeImmutable and $line['PREVISAO DE ENTREGA'] = $line['PREVISAO DE ENTREGA']->getTimestamp();
                        $line['DATA DO PEDIDO '] instanceof DateTimeImmutable and $line['DATA DO PEDIDO '] = $line['DATA DO PEDIDO ']->getTimestamp();
                        if (str($line['DATA DO PEDIDO '])->isEmpty() or str($line['PEDIDO'])->isEmpty()) {
                            return;
                        }
                        (!$line['PREVISAO DE ENTREGA'] instanceof DateTimeImmutable) and $line['PREVISAO DE ENTREGA'] = ($line['PREVISAO DE ENTREGA'] - 25569) * 86400;
                        (!$line['DATA DO PEDIDO '] instanceof DateTimeImmutable) and $line['DATA DO PEDIDO '] = ($line['DATA DO PEDIDO '] - 25569) * 86400;
                        $pedido = new Pedido;
                        $pedido->data_pedido = date('Y-m-d', $line['DATA DO PEDIDO ']);
                        $pedido->previsao_entrega = date('Y-m-d', $line['PREVISAO DE ENTREGA']);
                        $pedido->numero = $line['PEDIDO'];

                        $pedido->valor_contratual = $this->handleReal($line["VALOR DO PROJETO FINAL"]);
                        $pedido->valor = $this->handleReal($line["VALOR DO KIT"]);

                        $pedido->qtde_contratado = str($line['QTD MODULOS NO CONTRATO'])->whenEmpty(fn() => 0);
                        $pedido->qtde_pedido = str($line['QTD MODULOS NO PEDIDO'])->whenEmpty(fn() => 0);
                        $pedido->tipo_rede = TipoRede::fromString($line['AUMENTO DE CARGA 220 DA PRINCIPAL']);
                        $pedido->cliente()->associate($cliente);
                        $pedido->saveOrFail();
                        $rateios = null;
                        if (!str($line['RATEIO'])->isEmpty() and !str($line['RATEIO'])->lower()->replace('ã', 'a')->is("nao")) {
                            $rateios = ['nome' => $line['RATEIO']];
                        }
                        $rateios and $pedido->rateios()->create($rateios);
                    }
                );

            }

        );

    }
    private function handleReal(mixed $line)
    {
        if (is_string($line)) {
            if (str($line)->isEmpty())
                return $line = 0.0;
            $line = str_replace(['R$ ', '.'], '', $line);
            $line = str_replace(',', '.', $line);
            return floatval($line);
        }
        return floatval($line);
    }
}
