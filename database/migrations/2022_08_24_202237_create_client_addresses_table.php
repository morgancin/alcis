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
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_client_address');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id_client')->on('clients')->onDelete('cascade');

            $table->string('street', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('outdoor', 30)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('indoor', 30)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('suburb', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('town', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('city', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('state', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('country', 50)->collation('utf8mb4_unicode_ci')->default('México');
            $table->string('alias', 50)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('client_addresses');
    }
};
