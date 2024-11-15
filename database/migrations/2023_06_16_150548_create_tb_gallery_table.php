<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_gallery', function (Blueprint $table) {
            $table->id();
            $table->integer("_id")->nullable();
            $table->string("type_image",50)->nullable();
            $table->string("image",100)->nullable();
            $table->string("size",10)->nullable();
            $table->string("ext",10)->nullable();
           

            $table->enum('isActive',['Y','N'])->nullable()->default('Y');
            $table->string("created_by",50)->nullable();
            $table->string("updated_by",50)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_gallery');
    }
}
