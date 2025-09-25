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
        Schema::create('detail_sales_dos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sales_do')->nullable()->index();
            $table->string('produk')->nullable()->index();
            $table->integer('dus')->nullable();
            $table->integer('btl')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_sales_dos');
    }
};
