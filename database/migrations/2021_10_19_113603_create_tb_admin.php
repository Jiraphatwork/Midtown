<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTbAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image',100)->nullable();
            $table->integer("role")->nullable();
            $table->string('name',200)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('email',200)->nullable();
            $table->string('password',255)->nullable();
            $table->string('remember_token',255)->nullable();
            $table->text('detail')->nullable();
            $table->enum('isActive',['Y','N'])->nullable()->default('Y');
    
            $table->datetime('last_login_at')->nullable();
            $table->string("created_by",50)->nullable();
            $table->string("updated_by",50)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->softDeletes();
        });

        // Insert some stuff
        DB::table('tb_admin')->insert([
            [
                'role' => '1',
                'name' => 'Pipat Dev',
                'phone' => '',
                'email' => 'pipatdev',
                'password' => bcrypt('1234'),
                'isActive' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'), 
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_admin');
    }
}
