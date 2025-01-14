<?php

use App\Models\Pedido;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('relogio_bidirecionals', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('observacoes')->nullable();
            $table->foreignIdFor(Pedido::class)->constrained();
            $table->date('data_solicitacao');
            $table->date('data_retorno')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relogio_bidirecionals');
    }
};
