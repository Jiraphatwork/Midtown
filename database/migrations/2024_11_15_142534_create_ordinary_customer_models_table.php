<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdinaryCustomerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordinary_customer_models', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('email')->unique();
            $table->string("pic_id_card");
            $table->string("id_card", 13)->unique(); 
            $table->string("address", 500);
            $table->string("tel", 10); 
            $table->string("tel2", 10)->nullable(); 
            $table->string("tax_id")->nullable();
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
        Schema::dropIfExists('ordinary_customer_models');
    }
}
