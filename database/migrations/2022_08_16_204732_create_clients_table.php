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

            $table->string('firstname', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('lastname', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('email', 150)->collation('utf8mb4_unicode_ci');

            $table->string('officephone', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('mobilephone', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('homephone', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('profession', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('rfc', 15)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('curp', 20)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('servicepriority', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('prospectingorigin', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('prospectingmedium', 80)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedInteger('age')->nullable();
            $table->unsignedInteger('extension')->nullable();
            $table->date('birthday', $precision = 0)->nullable();

            $table->enum('gender', ['female', 'male'])->collation('utf8mb4_unicode_ci')->nullable();

            $table->string('state', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('city', 50)->collation('utf8mb4_unicode_ci')->nullable();

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
