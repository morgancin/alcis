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
        Schema::create('activity_participant', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_activity_participant');

            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')->references('id_activity')->on('activities')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id_person')->on('persons')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_participant');
    }
};
