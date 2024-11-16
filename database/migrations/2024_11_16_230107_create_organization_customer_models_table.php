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
            $table->string('email')->unique();
            $table->string("business_card");
            $table->string("address");
            $table->string("address2");
            $table->string("address3");
            $table->integer("tel")->nullable();
            $table->integer("fax");
            $table->integer("tel2");
            $table->integer("tax_id")->nullable();
            $table->string("card_slip")->nullable();
            $table->timestamps();

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
