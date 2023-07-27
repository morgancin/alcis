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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('email', 255)->collation('utf8mb4_unicode_ci')->unique();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->collation('utf8mb4_unicode_ci');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);

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
        Schema::dropIfExists('users');
    }
};
