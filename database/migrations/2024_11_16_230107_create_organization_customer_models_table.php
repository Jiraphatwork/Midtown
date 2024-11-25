<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationCustomerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_customer_models', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('email');
            $table->string("business_card");
            $table->string("address");
            $table->string("address2")->nullable(); 
            $table->string("address3")->nullable(); 
            $table->string("tel", 10)->nullable(); 
            $table->string("fax")->nullable(); 
            $table->string("tel2", 10)->nullable(); 
            $table->string("tax_id")->nullable(); 
            $table->string("card_slip")->nullable();
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
        Schema::dropIfExists('organization_customer_models');
    }
}
