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
        Schema ::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('code_transaksi');
            $table->integer('total_qty');
            $table->integer('user_id');
            $table->integer('total_harga');
            $table->string('nama_customer');
            $table->string('alamat');
            $table->integer('no_tlp');
            $table->string('ekspedisi');
            $table->enum('status', ['Unpaid','Paid','Send']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
