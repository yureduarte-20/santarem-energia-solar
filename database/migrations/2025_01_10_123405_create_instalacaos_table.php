<?php

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
        Schema::create('instalacaos', function (Blueprint $table) {
            $table->id();
            $table->date('data_prevista');
            $table->date('data_instalada')->nullable();
            $table->foreignIdFor(Pedido::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->text('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalacaos');
    }
};
