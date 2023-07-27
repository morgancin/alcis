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
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id('id');

            $table->string('template_name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedInteger('dynamic_index')->nullable();
            $table->enum('replace_type', ['raw', 'table'])->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('table_name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('table_column', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('raw_value', 255)->collation('utf8mb4_unicode_ci')->nullable();

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
        Schema::dropIfExists('whatsapp_templates');
    }
};
