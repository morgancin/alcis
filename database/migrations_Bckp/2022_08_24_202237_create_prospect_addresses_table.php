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
        Schema::create('prospect_addresses', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('prospect_id')->nullable();
            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');

            $table->string('street', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('outdoor', 30)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('indoor', 30)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('suburb', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('town', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('city', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('state', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('country', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('alias', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('zipcode', 5)->collation('utf8mb4_unicode_ci')->nullable();
            //$table->unsignedInteger('zipcode', 5)->nullable();

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
        Schema::dropIfExists('prospect_addresses');
    }
};
