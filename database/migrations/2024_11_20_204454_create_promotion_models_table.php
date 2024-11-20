<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_models', function (Blueprint $table) {
            $table->id();
            $table->string("name_promotion");
            $table->string("pic_promotion");
            $table->string("detail");
            $table->date("first_date");
            $table->date("last_date");
            $table->string("created_by",50)->nullable();
            $table->string("updated_by",50)->nullable();
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
        Schema::dropIfExists('promotion_models');
    }
}
