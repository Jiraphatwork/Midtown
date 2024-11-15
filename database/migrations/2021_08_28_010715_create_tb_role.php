<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateTbRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name",100)->nullable();
            $table->text("detail")->nullable();
      
            $table->enum('isActive',['Y','N'])->nullable()->default('Y');
            $table->string("created_by",50)->nullable();
            $table->string("updated_by",50)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        DB::table('tb_role')->insert([
            [ "id" => "1","name" => "Administrator","detail" => "Administrator root","isActive" => "Y","created_by" => "System","created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_role');
    }
}
