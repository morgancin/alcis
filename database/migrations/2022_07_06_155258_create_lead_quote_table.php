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
        Schema::create('lead_quote', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_lead_quote');

            $table->unsignedBigInteger('quote_id')->nullable();
            $table->foreign('quote_id')->references('id_quote')->on('quotes')->onDelete('cascade');

            $table->unsignedBigInteger('lead_id')->nullable();
            $table->foreign('lead_id')->references('id_lead')->on('leads')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_quote');
    }
};
