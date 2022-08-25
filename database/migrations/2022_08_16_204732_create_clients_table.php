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
        Schema::create('clients', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_client');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');

            $table->string('first_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('last_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('second_last_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->enum('gender', ['female', 'male'])->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('birth_date', $precision = 0);
            $table->unsignedInteger('age')->nullable();
            $table->string('birth_place', 50)->collation('utf8mb4_unicode_ci')->nullable();

            $table->string('email', 150)->collation('utf8mb4_unicode_ci');

            $table->string('phone_office', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone_mobile', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone_home', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('profession', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('rfc', 15)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('curp', 20)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('service_priority', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedInteger('extension')->nullable();

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
        Schema::dropIfExists('clients');
    }
};
