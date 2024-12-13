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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('causer_id')->constrained('users')->onDelete('cascade');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('description');
            $table->boolean('has_carcaca_animais')->default(false);
            $table->boolean('has_agua_parada')->default(false);
            $table->boolean('has_lixo_organico')->default(false);
            $table->boolean('has_produtos_quimicos')->default(false);
            $table->boolean('has_vidros')->default(false);
            $table->boolean('has_materias_reciclaveis')->default(false);
            $table->boolean('has_residuos_construcao')->default(false);
            $table->integer('score')->default(0);
            $table->boolean('checked')->default(false);
            $table->boolean('collected')->default(false);
            $table->foreignId('collected_causer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
