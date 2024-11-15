<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLogsList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_logs_list', function (Blueprint $table) {
            $table->id();
            $table->integer("log_id")->nullable();
            $table->enum("type",["backend","frontend"])->default('backend');
            $table->enum("level",["Debug","Info","Warning","Error"])->default('Error');
            $table->datetime('date')->nullable();
            $table->string("env",50)->nullable();
            $table->integer("line")->nullable();
            $table->text("url")->nullable();
            $table->text("desc")->nullable()->comment("รายละเอียดย่อ");
            $table->text("detail")->nullable()->comment("รายละเอียด");

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
        Schema::dropIfExists('tb_logs_list');
    }
}
