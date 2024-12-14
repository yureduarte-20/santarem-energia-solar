<?php

use App\Models\Pedido;
use App\Models\TipoDocumento;
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
        Schema::create('pedido_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pedido::class)->constrained();
            $table->foreignIdFor(TipoDocumento::class)->constrained();
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
        Schema::dropIfExists('pedido_documentos');
    }
};
