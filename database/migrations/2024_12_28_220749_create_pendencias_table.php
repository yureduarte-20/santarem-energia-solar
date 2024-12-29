<?php

use App\Models\Engenheiro;
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
        Schema::create('pendencias', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Engenheiro::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Pedido::class)->constrained();
            $table->mediumText('conteudo');
            $table->boolean('atendida')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendencias');
    }
};
