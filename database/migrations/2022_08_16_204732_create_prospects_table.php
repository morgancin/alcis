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
        Schema::create('prospects', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->unsignedBigInteger('pipeline_stage_id')->nullable();
            $table->foreign('pipeline_stage_id')->references('id')->on('pipeline_stages')->onDelete('cascade');

            $table->string('first_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('last_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('second_last_name', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->enum('gender', ['female', 'male'])->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('birth_date', $precision = 0)->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('birth_place', 50)->collation('utf8mb4_unicode_ci')->nullable();

            $table->string('email', 150)->collation('utf8mb4_unicode_ci');

            $table->string('phone_office', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone_mobile', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone_home', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('profession', 80)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('tax_id', 15)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('tax_regime', 15)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('principal_usage', 15)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('population_reg', 20)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('priority', 80)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedDecimal('potential_value', 8, 2)->nullable();

            $table->unsignedInteger('extension')->nullable();

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
        Schema::dropIfExists('prospects');
    }
};
