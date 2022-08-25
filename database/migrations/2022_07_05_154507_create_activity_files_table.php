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
        Schema::create('activity_files', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_activity_file');

            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')->references('id_activity')->on('activities')->onDelete('cascade');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('path', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('activity_files');
    }
};
