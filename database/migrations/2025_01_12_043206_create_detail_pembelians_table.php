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
        if (Schema::hasTable('detail_pembelians')) {
            Schema::dropIfExists('detail_pembelians');
        }

        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembelian');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_supplier');
            $table->integer('qty');
            $table->decimal('harga_beli', 10, 2);
            $table->timestamps();

            $table->foreign('id_pembelian')
                ->references('id')
                ->on('pembelians')
                ->onDelete('cascade');

            $table->foreign('id_barang')
                ->references('id')
                ->on('barangs')
                ->onDelete('cascade');

            $table->foreign('id_supplier')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('detail_pembelians');
        Schema::enableForeignKeyConstraints();
    }
};
