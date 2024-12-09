<?php

use App\Models\MetodoPagamento;
use App\Models\Pedido;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedido_metodo_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pedido::class)->constrained();
            $table->foreignIdFor(MetodoPagamento::class)->constrained();
            $table->decimal('valor');
            $table->boolean('quitado');
            $table->date('data_pagamento');
            $table->date('vencimento');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_metodo_pagamentos');
    }
};
