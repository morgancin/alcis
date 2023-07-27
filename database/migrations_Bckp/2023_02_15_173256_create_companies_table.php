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
        Schema::create('companies', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone', 30)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('website', 100)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('address', 100)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedDecimal('potential_value', 8, 2)->nullable();
            $table->string('tax_id', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('comments', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('companies');
    }
};
