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
        Schema::create('categories_groups', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->boolean('active');
            $table->unsignedInteger('type')->nullable();
            $table->unsignedBigInteger('item_group_id')->nullable();
            $table->unsignedBigInteger('category_group_id')->nullable();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('image', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('categories_groups');
    }
};
