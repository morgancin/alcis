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
        Schema::create('activities', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_activity');

            $table->string('title', 255)->collation('utf8_general_ci')->nullable();
            $table->string('type', 255)->collation('utf8_general_ci')->nullable();
            $table->text('comment')->collation('utf8_general_ci')->nullable();

            $table->json('additional')->nullable();
            $table->dateTime('schedule_to', $precision = 0)->nullable();
            $table->dateTime('schedule_from', $precision = 0)->nullable();
            $table->unsignedTinyInteger('is_done')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');

            $table->string('location', 255)->collation('utf8_general_ci')->nullable();

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
        Schema::dropIfExists('activities');
    }
};
