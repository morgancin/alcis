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
        Schema::create('emails', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->string('subject', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('source', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('user_type', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('reply')->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedTinyInteger('is_read')->nullable();

            $table->json('folders')->nullable();
            $table->json('from')->nullable();
            $table->json('sender')->nullable();
            $table->json('reply_to')->nullable();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();

            $table->string('unique_id', 255)->collation('utf8mb4_unicode_ci')->unique();
            //$table->foreign('unique_id');

            $table->json('reference_ids')->nullable();
            $table->string('message_id', 255)->collation('utf8mb4_unicode_ci')->nullable();

            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');

            $table->unsignedBigInteger('lead_id')->nullable();
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');

            $table->unsignedBigInteger('parent_id')->nullable();
            //$table->foreign('parent_id');

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
        Schema::dropIfExists('emails');
    }
};
