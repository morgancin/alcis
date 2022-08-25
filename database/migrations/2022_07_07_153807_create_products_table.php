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
        Schema::create('products', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_product');

            $table->string('sku', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('description', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedDecimal('price', 12, 4)->nullable();

            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->foreign('categorie_id')->references('id_categorie')->on('categories')->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
};
