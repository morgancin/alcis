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
            $table->id('id');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->timestamp('activity_date')->nullable(); // ALMACENA PARA CUÁNDO SERÁ LA ACTIVITY
            $table->timestamp('start_date')->nullable();    //ALMACENA CUANDO INICIA LA ACTIVITY
            $table->timestamp('end_date')->nullable();      //ALMACENA CUANDO FINALIZA LA ACTIVITY
            $table->boolean('on_time')->nullable();
            $table->unsignedDecimal('potential_value', 8, 2)->nullable();

            /*
            $table->date('activity_date', $precision = 0);

            $table->timestamp('end_date')->nullable();
            $table->timestamp('start_date')->nullable();

            $table->time('start_time', $precision = 0)->nullable();
            $table->time('end_time', $precision = 0)->nullable();
            */

            $table->string('comments', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('observations', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
