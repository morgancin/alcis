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
        Schema::create('client_origins', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_client_origin');

            $table->string('description', 100)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedBigInteger('parent_id_client_medium')->nullable();
            $table->foreign('parent_id_client_medium')->references('id_client_origin')->on('client_origins')->onDelete('cascade');

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
        Schema::dropIfExists('client_origins');
    }
};
