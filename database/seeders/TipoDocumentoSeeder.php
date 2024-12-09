<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoDocumento::createOrFirst([
            'nome' => 'Procuração'
        ]);
        TipoDocumento::createOrFirst([
            'nome' => 'Comprovante de Residência'
        ]);
        TipoDocumento::createOrFirst([
            'nome' => 'Contrato'
        ]);
        TipoDocumento::createOrFirst([
            'nome' => 'RG'
        ]);
        TipoDocumento::createOrFirst([
            'nome' => 'CPF'
        ]);
        TipoDocumento::createOrFirst([
            'nome' => 'Informações do KIT'
        ]);
    }
}
