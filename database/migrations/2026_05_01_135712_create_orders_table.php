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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // relasi customer/user
            $table->unsignedBigInteger('customer_id');

            // data penerima
            $table->string('receiver_name');
            $table->string('receiver_phone');

            // alamat pengiriman
            $table->text('address');

            // metode pengiriman & pembayaran
            $table->string('shipping_method');
            $table->string('payment_method');

            // total belanja
            $table->decimal('total', 12, 2);

            // status order
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
