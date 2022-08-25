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
        Schema::create('persons', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_person');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->json('emails')->nullable();
            $table->json('contact_numbers')->nullable();

            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('id_organization')->on('organizations')->onDelete('cascade');

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
        Schema::dropIfExists('people');
    }
};
