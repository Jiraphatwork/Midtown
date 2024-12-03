<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAreaModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_area_models', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['รูปแบบที่1', 'รูปแบบที่2', 'รูปแบบที่3']);
            $table->string('pic_area');
            $table->string('area');
            $table->string('price');
            
            $table->string("created_by", 50)->nullable();
            $table->string("updated_by", 50)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_area_models');
    }
}
