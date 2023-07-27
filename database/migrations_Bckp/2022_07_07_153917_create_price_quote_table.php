<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_product_quote', function (Blueprint $table) {
        //Schema::create('quote_items', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('quote_id')->nullable();
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            //$table->unsignedBigInteger('price_id')->nullable();
            //$table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');

            //$table->unsignedDecimal('tax_percent', 12, 4)->nullable();
            //$table->unsignedDecimal('tax_amount', 12, 4)->nullable();
            //$table->string('sku', 255)->collation('utf8mb4_unicode_ci')->nullable();
            //$table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedDecimal('price', 8, 2)->nullable();
            $table->string('coupon_code', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedDecimal('discount_percent', 8, 2)->nullable();
            $table->unsignedDecimal('discount_amount', 8, 2)->nullable();
            $table->unsignedDecimal('amount', 8, 2)->nullable();
            $table->unsignedDecimal('total', 8, 2)->nullable();

            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_product_quote');
    }
};
