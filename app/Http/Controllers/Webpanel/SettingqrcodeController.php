<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\SettingqrcodeModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SettingqrcodeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'settingqrcode';
    protected $folder = 'settingqrcode';

    public function index(Request $request)
    {
        $items = SettingqrcodeModel::all();
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'items' => $items,
        ]);
    }

    public function add(Request $request)
    {
        return view("$this->prefix.pages.$this->folder.add", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
        ]);
    }
    public function edit(Request $request, $id)
    {
        $item = SettingqrcodeModel::find($id);
        return view("$this->prefix.pages.$this->folder.edit", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'item' => $item,
        ]);
    }
    //==== Function Insert Update Delete Status Sort & Others ====
    public function insert(Request $request, $id = null)
    {
        return $this->store($request, $id = null);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        return $this->store($request, $id);
    }

    public function store(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $user = AdminModel::find(Auth::guard('admin')->id());

            if ($id == null) {
                // กรณีเพิ่มข้อมูลใหม่
                $data = new SettingqrcodeModel();
                $data->created_at = now();
                $data->created_by = $user->email;
            } else {
                // กรณีแก้ไขข้อมูล
                $data = SettingqrcodeModel::find($id);
                $data->updated_by = $user->email;
                $data->updated_at = now();
            }

            $data->name_account = $request->name_account;

            // ถ้ามีการส่งค่ามาเพื่อบอกให้ลบรูปภาพ
            if ($request->delete_image == '1' && $data->image_path) {
                // ลบไฟล์เก่าจาก storage
                $oldFilePath = storage_path('app/public/' . $data->image_path);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);  // ลบไฟล์เก่า
                }
                $data->image_path = null;  // ลบข้อมูล image_path ในฐานข้อมูล
            }

            // ถ้ามีการอัปโหลดรูปภาพใหม่
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/id_cards', $fileName, 'public');
                $data->image_path = $filePath;
            }

            // บันทึกข้อมูล
            if ($data->save()) {
                DB::commit();
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error during saving data', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function destroy($id)
{
    try {
        $item = SettingqrcodeModel::find($id);

        if ($item) {
            // ตรวจสอบและลบไฟล์ภาพที่เกี่ยวข้อง
            if (!empty($item->image_path)) {
                Storage::disk('public')->delete($item->image_path); // ลบไฟล์
            }

            // ลบข้อมูลจากฐานข้อมูล
            $item->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    } catch (\Exception $e) {
        Log::error("Error during deleting data", ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}

    
    
}
