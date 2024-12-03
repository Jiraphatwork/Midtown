<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTbMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('_id')->nullable();
            $table->string('name',100)->nullable();
            $table->text('url')->nullable();
            $table->text('icon')->nullable();
            $table->enum('position',['main','secondary','topic'])->nullable();


            $table->integer('sort')->nullable();
            $table->enum('status',['on','off'])->nullable()->default('on');
            $table->enum('delete_status',['on','off'])->nullable()->default('off');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
        });

        DB::table('tb_menu')->insert([
            [ "id" => "1", "_id"=>null, "name"=>"Template Form", "url"=>"templateform", "icon"=>"settings", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "2", "_id"=>"1", "name"=>"Standard", "url"=>"templateform/standard", "icon"=>"", "position"=>"secondary", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "3", "_id"=>"1", "name"=>"Modal", "url"=>"templateform/modal", "icon"=>"", "position"=>"secondary", "sort"=>"2", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "4", "_id"=>null, "name"=>"ประวัติการจอง", "url"=>"webpanel/reserve_history", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "5", "_id"=>null, "name"=>"ปฏิทินการจอง", "url"=>"webpanel/calendar", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "6", "_id"=>null, "name"=>"ข้อมูลลูกค้า", "url"=>"webpanel", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "7", "_id"=>"6", "name"=>"ข้อมูลลูกค้า(บุคคล)", "url"=>"webpanel/ordinary_customer", "icon"=>"", "position"=>"secondary", "sort"=>"2", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "8", "_id"=>"6", "name"=>"ข้อมูลลูกค้า(องกรณ์)", "url"=>"webpanel/organization_customer", "icon"=>"", "position"=>"secondary", "sort"=>"2", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "9", "_id"=>"6", "name"=>"ข้อมูลลูกค้า(Agent)", "url"=>"webpanel/agent_customer", "icon"=>"", "position"=>"secondary", "sort"=>"2", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "10", "_id"=>null, "name"=>"ข้อมูลอุปกรณ์", "url"=>"webpanel/data_equipment", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "11", "_id"=>null, "name"=>"ข้อมูลโปรโมชั่น", "url"=>"webpanel/promotion", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "12", "_id"=>null, "name"=>"ข้อมูลติดต่อเรา", "url"=>"webpanel/data_contact", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "13", "_id"=>null, "name"=>"ตั้งค่าข้อมูลเงื่อนไขการคืนเงินการยกเลิก", "url"=>"webpanel/settingrefund", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "14", "_id"=>null, "name"=>"ตั้งค่าข้อมูลการสแกนจ่าย qr code", "url"=>"webpanel/settingqrcode", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "15", "_id"=>null, "name"=>"ตั้งค่าข้อมูลเงื่อนการสมัครสมาชิกข้อตกลง", "url"=>"webpanel/settingmembership", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "16", "_id"=>null, "name"=>"ตั้งค่าสิทธิ์ผู้ใช้งาน", "url"=>"webpanel/settingadmin", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
            [ "id" => "17", "_id"=>null, "name"=>"ข้อมูลพื้นที่", "url"=>"webpanel/settingarea", "icon"=>"", "position"=>"main", "sort"=>"1", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s') ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_menu');
    }
}
