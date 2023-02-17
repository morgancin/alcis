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
        Schema::create('tags', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            //$table->unsignedBigInteger('account_id')->nullable();
            //$table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->enum('type', ['tag', 'list'])->collation('utf8mb4_unicode_ci')->nullable();
            //$table->string('color', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('tags');
    }
};
