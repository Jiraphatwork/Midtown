<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReserveHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve_histories', function (Blueprint $table) {
            $table->id(); // Primary key ID
            $table->string("name"); // 
            $table->date("now_date"); // วันที่จ่าย
            $table->date("first_date"); // วันที่เริ่มต้น
            $table->date("last_date"); // วันที่สิ้นสุด
            $table->enum("status", ["จ่ายแล้ว", "ยังไม่จ่าย"]); 
            $table->string("product_type"); 
            $table->string("area"); 

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
        Schema::dropIfExists('reserve_histories');
    }
}
