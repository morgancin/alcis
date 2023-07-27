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
        //Schema::create('document_price_product', function (Blueprint $table) {
        //Schema::create('quote_items', function (Blueprint $table) {
        Schema::create('currency_document_price_list_product', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('document_id')->nullable();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('price_list_id')->nullable();
            $table->foreign('price_list_id')->references('id')->on('price_lists')->onDelete('cascade');

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');

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
        Schema::dropIfExists('currency_document_price_list_product');
    }
};
