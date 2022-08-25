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
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id_email_attachment');

            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('path', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedInteger('size')->nullable();

            $table->string('content_type', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('content_id', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedBigInteger('email_id')->nullable();
            //$table->foreign('email_id');

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
        Schema::dropIfExists('email_attachments');
    }
};
