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
        Schema::create('leads', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->string('title', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('description')->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedDecimal('lead_value', 12, 4)->nullable();
            $table->unsignedTinyInteger('status')->nullable();

            /////
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');

            $table->unsignedBigInteger('lead_source_id')->nullable();
            $table->foreign('lead_source_id')->references('id')->on('lead_sources')->onDelete('cascade');

            $table->unsignedBigInteger('lead_type_id')->nullable();
            $table->foreign('lead_type_id')->references('id')->on('lead_types')->onDelete('cascade');

            $table->unsignedBigInteger('lead_pipeline_id')->nullable();
            $table->foreign('lead_pipeline_id')->references('id')->on('lead_pipelines')->onDelete('cascade');

            $table->unsignedBigInteger('lead_pipeline_stage_id')->nullable();
            $table->foreign('lead_pipeline_stage_id')->references('id')->on('lead_pipeline_stage')->onDelete('cascade');
            //////////

            $table->text('lost_reason')->collation('utf8mb4_unicode_ci')->nullable();
            $table->dateTime('closed_at', $precision = 0);

            $table->date('expected_close_date', $precision = 0);

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
        Schema::dropIfExists('leads');
    }
};
