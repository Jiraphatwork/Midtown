<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_customer', function (Blueprint $table) {
            $table->id();
            $table->string("firstname",50)->nullable();
            $table->string("lastname",50)->nullable();
            $table->string("idcard",20)->nullable();
            $table->string("phone",20)->nullable();
            $table->enum("sex",['ชาย','หญิง'])->nullable();
            $table->date("birthdate")->nullable();
            $table->integer("age")->nullable();
            $table->integer("height")->nullable();
            $table->integer("weight")->nullable();
            $table->double("bmi")->nullable();
            $table->string("image",100)->nullable();
            $table->text("token_line")->nullable();

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
        Schema::dropIfExists('tb_customer');
    }
}
