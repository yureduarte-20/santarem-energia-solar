<?php

use App\Enums\TipoRede;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->date('data_pedido');
            $table->date('previsao_entrega');
            $table->date('data_entrega')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->unsignedInteger('qtde_contratado');
            $table->unsignedInteger('qtde_entregue');
            $table->foreignIdFor(Cliente::class)->constrained();
            $table->decimal('valor_contratual', 8, 2);
            $table->decimal('valor', 8, 2);
            $table->text('descricao')->nullable();
            $table->enum('tipo_rede', TipoRede::values());
            $table->boolean('entregue')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
