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
        Schema::create('documents', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->string('code', 100)->collation('utf8mb4_unicode_ci')->nullable();

            $table->dateTime('ship_date', $precision = 0);

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('prospect_id')->nullable();
            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');

            $table->unsignedBigInteger('invoicing_address_id')->nullable();
            $table->foreign('invoicing_address_id')->references('id')->on('prospect_addresses')->onDelete('cascade');

            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->foreign('shipping_address_id')->references('id')->on('prospect_addresses')->onDelete('cascade');

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');

            $table->unsignedBigInteger('payment_terms_id')->nullable();
            $table->foreign('payment_terms_id')->references('id')->on('payment_terms')->onDelete('cascade');

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');

            $table->unsignedBigInteger('order_status_id')->nullable();
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');

            $table->enum('status', ['O', 'C'])->default('O');
            $table->enum('type', ['B', 'S', 'I'])->default('S');
            $table->enum('class', ['QO', 'SO', 'IN'])->default('QO');

            $table->unsignedDecimal('exchange_rate', 8, 2)->nullable();

            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');

            $table->string('contact_person', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('contact_person_phone', 10)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('reference', 100)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('comments', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedDecimal('discount_percent', 8, 2)->nullable();
            $table->unsignedDecimal('discount_amount', 8, 2)->nullable();
            $table->unsignedDecimal('sub_total', 8, 2)->nullable();
            $table->unsignedDecimal('tax_amount', 8, 2)->nullable();
            $table->unsignedDecimal('total', 8, 2)->nullable();

            $table->dateTime('expires_at', $precision = 0); //SE ALMACENA EN BACK
            $table->dateTime('canceled_at', $precision = 0);

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
        Schema::dropIfExists('documents');
    }
};
