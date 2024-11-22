<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCustomerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_customer_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('business_card')->nullable(); 
            $table->string('tax_card')->nullable(); 
            $table->string('pic_id_card')->nullable(); // รูปบัตรประชาชน
            $table->string('id_card', 13)->unique(); // รหัสบัตรประชาชน
            $table->string('address');
            $table->string('address2')->nullable(); // ที่อยู่สำรอง 1
            $table->string('address3')->nullable(); // ที่อยู่สำรอง 2
            $table->string('tel', 10); // เบอร์โทรศัพท์หลัก
            $table->string('fax')->nullable(); // แฟกซ์
            $table->string('tel2', 10)->nullable(); // เบอร์โทรศัพท์สำรอง
            $table->string('tax_id')->nullable(); // เลขประจำตัวผู้เสียภาษี
            $table->string('slip_card')->nullable(); // ทำให้ไฟล์เป็น nullable            
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
        Schema::dropIfExists('agent_customer_models');
    }
}
