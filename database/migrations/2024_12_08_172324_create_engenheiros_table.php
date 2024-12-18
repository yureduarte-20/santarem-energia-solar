<?php

use App\Models\Conta;
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
        Schema::create('engenheiros', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 11)->unique();
            $table->foreignIdFor(Conta::class)->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engenheiros');
    }
};
