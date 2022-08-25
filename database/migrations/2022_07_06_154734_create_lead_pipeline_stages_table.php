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
        Schema::create('lead_pipeline_stage', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_lead_pipeline_stage');

            $table->string('code', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedInteger('probability')->nullable();
            $table->unsignedInteger('sort_order')->nullable();

            $table->unsignedBigInteger('lead_pipeline_id')->nullable();
            $table->foreign('lead_pipeline_id')->references('id_lead_pipeline')->on('lead_pipelines')->onDelete('cascade');

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
        Schema::dropIfExists('lead_pipeline_stages');
    }
};
