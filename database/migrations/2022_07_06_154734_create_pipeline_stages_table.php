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
        Schema::create('pipeline_stages', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('pipeline_id')->nullable();
            $table->foreign('pipeline_id')->references('id')->on('pipelines')->onDelete('cascade');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedInteger('percent')->nullable();
            $table->unsignedInteger('sort_order')->nullable();

            //$table->string('code', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('pipeline_stages');
    }
};
