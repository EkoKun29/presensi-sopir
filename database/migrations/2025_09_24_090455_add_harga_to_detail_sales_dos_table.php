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
        Schema::table('detail_sales_dos', function (Blueprint $table) {
            $table->integer('harga')->nullable()->after('total');
            $table->integer('hpp')->nullable()->after('harga');
            $table->integer('laba')->nullable()->after('hpp');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_sales_dos', function (Blueprint $table) {
            $table->dropColumn('harga','hpp', 'laba');
            
        });
    }
};
