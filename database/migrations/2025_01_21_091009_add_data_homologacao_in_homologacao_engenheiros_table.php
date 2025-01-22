<?php

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
        Schema::table('homologacao_engenheiros', function (Blueprint $table) {
            $table->date('data_homologacao')->nullable();
            $table->text('observacoes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homologacao_engenheiros', function (Blueprint $table) {
            $table->dropColumn('data_homologacao');
            $table->dropColumn('observacoes');
        });
    }
};
