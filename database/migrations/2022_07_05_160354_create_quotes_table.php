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
        Schema::create('quotes', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_quote');

            $table->string('subject', 255)->collation('utf8_general_ci')->nullable();
            $table->string('description', 255)->collation('utf8_general_ci')->nullable();

            $table->json('billing_address')->nullable();
            $table->json('shipping_address')->nullable();

            $table->unsignedDecimal('discount_percent', 8, 2)->nullable();
            $table->unsignedDecimal('discount_amount', 8, 2)->nullable();
            $table->unsignedDecimal('tax_amount', 8, 2)->nullable();
            $table->unsignedDecimal('adjustment_amount', 8, 2)->nullable();
            $table->unsignedDecimal('sub_total', 8, 2)->nullable();
            $table->unsignedDecimal('grand_total', 8, 2)->nullable();

            $table->dateTime('expire_at', $precision = 0);

            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id_person')->on('persons')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('quotes');
    }
};
