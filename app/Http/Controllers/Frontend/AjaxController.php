<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//=== Models ===
use App\Models\Backend\BrandModel;
use App\Models\Backend\Brand_listModel;
use App\Models\Backend\CategoryModel;
use App\Models\Backend\Sub_categoryModel;
use App\Models\Backend\ProvinceModel;
use App\Models\Backend\AmupurModel;
use App\Models\Backend\TambonModel;
use App\Models\Backend\MemberModel;


class AjaxController extends Controller
{
    public function getProvince(Request $request)
    {
        $id = $request->province_id;
        $data = ProvinceModel::find($id);
        $items = AmupurModel::where('province_id',$id)->get();
        if($items)
        {
            echo '<option value="" selected>- กรุณาเลือกข้อมูล -</option>';
            foreach ($items as $key=>$item) {
                echo '<option value="'.$item->id.'">'.$item->name_th.'</option>';
            }
        }
    }

    public function getAmupur(Request $request)
    {
        $id = $request->amupur_id;
        $data = AmupurModel::find($id);
        $items = TambonModel::where('amupur_id',$data->id)->get();
        if($items)
        {
            echo '<option value="" selected>- กรุณาเลือกข้อมูล -</option>';
            foreach ($items as $key=>$item) {
                echo '<option value="'.$item->id.'">'.$item->name_th.'</option>';
            }
        }
    }

    public function getTambon(Request $request)
    {
        $id = $request->tambon_id;
        $data = TambonModel::find($id);
        if($data)
        {
        $arr['zip_code'] = $data->zip_code;
        }
        echo json_encode($arr);
    }
}
