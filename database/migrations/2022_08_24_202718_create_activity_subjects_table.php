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
        Schema::create('activity_subjects', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('activity_type_id')->nullable();
            $table->foreign('activity_type_id')->references('id')->on('activity_types')->onDelete('cascade');

            $table->string('name', 100)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('activity_subjects');
    }
};
