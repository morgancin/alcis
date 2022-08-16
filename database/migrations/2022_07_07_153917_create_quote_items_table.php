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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_quote_item');

            $table->string('sku', 255)->collation('utf8_general_ci')->nullable();
            $table->string('name', 255)->collation('utf8_general_ci')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedDecimal('price', 12, 4)->nullable();
            $table->string('coupon_code', 255)->collation('utf8_general_ci')->nullable();
            $table->unsignedDecimal('discount_percent', 12, 4)->nullable();
            $table->unsignedDecimal('discount_amount', 12, 4)->nullable();
            $table->unsignedDecimal('tax_percent', 12, 4)->nullable();
            $table->unsignedDecimal('tax_amount', 12, 4)->nullable();
            $table->unsignedDecimal('total', 12, 4)->nullable();

            $table->unsignedBigInteger('quote_id')->nullable();
            $table->foreign('quote_id')->references('id_quote')->on('quotes')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_items');
    }
};
