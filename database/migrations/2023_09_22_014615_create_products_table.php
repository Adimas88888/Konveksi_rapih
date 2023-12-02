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
        Schema ::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('nama_product');
            $table->string('type');
            $table->string('kategory');
            $table->bigInteger('harga');
            $table->integer('quantity')->default(0);
            $table->integer('quantity_out')->default(0);
            $table->text('foto')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
