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
        Schema::create('leads', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            //$table->unsignedBigInteger('prospect_id')->nullable();
            //$table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');

            //$table->unsignedBigInteger('prospecting_mean_id')->nullable();
            //$table->foreign('prospecting_mean_id')->references('id')->on('prospecting_sources')->onDelete('cascade');

            $table->string('email', 150)->collation('utf8mb4_unicode_ci');
            $table->string('last_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('comments', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('first_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('second_last_name', 50)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedBigInteger('first_assignation_user_id')->nullable();
            $table->foreign('first_assignation_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('first_assignation_at', $precision = 0)->nullable();

            $table->unsignedBigInteger('second_assignation_user_id')->nullable();
            $table->foreign('second_assignation_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('second_assignation_at', $precision = 0)->nullable();

            $table->unsignedBigInteger('final_assignation_user_id')->nullable();
            $table->foreign('final_assignation_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('attended_at', $precision = 0)->nullable();

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
        Schema::dropIfExists('leads');
    }
};
