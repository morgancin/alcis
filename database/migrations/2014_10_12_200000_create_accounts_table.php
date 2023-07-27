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
        Schema::create('accounts', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->string('tax_id', 15)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone_office', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('website', 200)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('address', 200)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedDecimal('potential_value', 8, 2)->nullable();
            $table->string('comments', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);

            $table->unsignedBigInteger('created_user_id')->nullable();
            $table->foreign('created_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->foreign('updated_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
