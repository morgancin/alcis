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
        Schema::create('lead_pipelines', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_lead_pipeline');

            $table->string('name', 255)->collation('utf8_general_ci')->nullable();
            $table->unsignedTinyInteger('is_default')->nullable();
            $table->unsignedInteger('rotten_days')->nullable();

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
        Schema::dropIfExists('lead_pipelines');
    }
};
