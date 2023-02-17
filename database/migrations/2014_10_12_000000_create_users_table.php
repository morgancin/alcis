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

            $table->string('email', 255)->collation('utf8mb4_unicode_ci')->unique();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedTinyInteger('status')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->collation('utf8mb4_unicode_ci');

            //$table->string('image', 255)->collation('utf8mb4_unicode_ci')->nullable();

            //$table->unsignedBigInteger('role_id')->nullable();
            //$table->foreign('subcategoria_id')->references('id_subcategoria')->on('subcategorias')->onDelete('cascade');

            //$table->unsignedInteger('anovencimiento')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
