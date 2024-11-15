<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTestformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_testform', function (Blueprint $table) {
            $table->id();
            $table->string("image",100)->nullable();
            $table->string("name",50)->nullable();
            $table->text("detail")->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('amupur_id')->nullable();
            $table->unsignedBigInteger('tambon_id')->nullable();
            $table->string("zip_code",50)->nullable();
           

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
        Schema::dropIfExists('tb_testform');
    }
}
