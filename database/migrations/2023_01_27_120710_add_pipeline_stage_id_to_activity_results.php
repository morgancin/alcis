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
        Schema::table('activity_results', function (Blueprint $table) {
            $table->unsignedBigInteger('pipeline_stage_id')->nullable();
            $table->foreign('pipeline_stage_id')->references('id')->on('pipeline_stages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_results', function (Blueprint $table) {
            $table->dropColumn('pipeline_stage_id');
        });
    }
};
