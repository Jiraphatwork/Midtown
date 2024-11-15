<?php

namespace App\Http\Controllers\Webpanel\Template;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\FunctionControl;
use App\Http\Controllers\Functions\MenuControl;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Webpanel\LogsController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

use App\Models\Backend\TestformModel;
use App\Models\Backend\GalleryModel;

//== Province , Amupur , Tambon
use App\Models\Backend\ProvinceModel;
use App\Models\Backend\AmupurModel;
use App\Models\Backend\TambonModel;


class ModalController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'template';
    protected $folder_controller = 'template.modal';
    protected $folder = 'templateform/modal';
    protected $name_page = "รายการผู้ดูแล";
    
    public function imageSize($find = null)
    {
        $arr = [
            'cover' => [
                'sm' => ['x' => 34, 'y' => 34],
                'md' => ['x' => 2505, 'y' => 1305],
            ],
        ];
        if ($find == null) {
            return $arr;
        } else {
            switch ($find) {
                case 'cover':
                    return $arr['cover'];
                    break;
                case 'gallery':
                    return $arr['gallery'];
                    break;
                default:
                    return [];
                    break;
            }
        }
    }

    public function items($parameters)
    {
        $search = Arr::get($parameters, 'search');
        // $sort = Arr::get($parameters, 'sort', 'asc');
        $paginate = Arr::get($parameters, 'total', 15);
        $query = new TestformModel;
        if ($search) {
            $query = $query->where('name_th', 'LIKE', '%' . trim($search) . '%');
            $query = $query->where('name_en', 'LIKE', '%' . trim($search) . '%');
        }
        // $query = $query->orderBy('sort', $sort);
        $query = $query->orderBy('id', 'asc');
        $results = $query->paginate($paginate);
        return $results;
    }

    public function index(Request $request)
    {
        $items = $this->items($request->all());
        $items->pages = new \stdClass();
        $items->pages->start = ($items->perPage() * $items->currentPage()) - $items->perPage();


        $navs = [
            '0' => ['url' => "javascript:void(0)", 'name' => "Administrator", "last" => 0],
            '1' => ['url' => "$this->segment/$this->folder", 'name' => "User", "last" => 1],
        ];
        return view("$this->prefix.pages.$this->folder_controller.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'navs' => $navs,
            'items' => $items,
        ]);
    }

    public function create_modal(Request $request)
    {
         return view("$this->prefix.pages.$this->folder_controller.modal-create", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'provinces' => ProvinceModel::get(),
        ]);
    }

    public function edit_modal(Request $request)
    {
        $data = TestformModel::find($request->id);
         return view("$this->prefix.pages.$this->folder_controller.modal-edit", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'row' => $data,
            'gallerys' => GalleryModel::where(["type_image"=> 'templateform', "_id"=>$data->id])->get(),
            'provinces' => ProvinceModel::get(),
            'amupurs' => AmupurModel::where('province_id',$data->province_id)->get(),
            'tambons' => TambonModel::where('amupur_id',$data->amupur_id)->get(),
        ]);
    }
    public function destroy(Request $request)
    {
        $datas = TestformModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                $gallerys = GalleryModel::where(["type_image"=> 'templateform', "_id"=> $data->id])->get();
                if($gallerys){
                    foreach($gallerys as $gallery){
                        FunctionControl::galleryDeleteAll($gallery->id);
                    }
                }
                Storage::disk('public')->delete($data->image);
                $query = TestformModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    //==== Function Insert Update Delete Status Sort & Others ====
    public function insert(Request $request, $id = null)
    {
        return $this->store($request, $id = null);
    }
    public function update(Request $request, $id)
    {
        return $this->store($request, $id);
    }
    public function store($request, $id = null)
    {
        try {
            DB::beginTransaction();
            if ($id == null) {
                $data = new TestformModel();
                $data->created_at = date('Y-m-d H:i:s');
                $data->updated_at = date('Y-m-d H:i:s');
            } else {
                $data = TestformModel::find($id);
                $data->updated_at = date('Y-m-d H:i:s');
            }
            $data->name = $request->name;
            $data->detail = $request->detail;
            $data->province_id = $request->province_id;
            $data->amupur_id = $request->amupur_id;
            $data->tambon_id = $request->tambon_id;
            $data->zip_code = $request->zip_code;

            // Image upload
            if($request->image != ''){
                $image = FunctionControl::upload_image2($request->image,'templateform');
                $data->image = $image['image'];
            }
            if ($data->save()) 
            {
                DB::commit();
                // Image upload
                $filename = 'gallery_' . date('dmY-His');
                $file = $request->gallery_image;
                if ($file) 
                {
                    foreach($file as $key=>$file_gallery)
                    {
                        $image_gallery = FunctionControl::upload_gallery($file_gallery,$key,'templateform/gallery');
                        if($image_gallery)
                        {
                            $gallery = new GalleryModel();
                            $gallery->_id = $data->id;
                            $gallery->type_image = 'templateform';
                            $gallery->image = $image_gallery['image'];
                            $gallery->size = $image_gallery['size'];
                            $gallery->ext = $image_gallery['ext'];
                            $gallery->save();
                        }
                    }
                }
                $arr = [
                    'status' => '200',
                    'result' => 'success',
                    'message' => 'ดำเนินการสำเร็จ'
                ];
            } else {
                $arr = [
                    'status' => '500',
                    'result' => 'error',
                    'message' => 'เกิดข้อผิดพลาด'
                ];
            }
            echo json_encode($arr);
        } catch (\Exception $e) {
            DB::rollback();
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            LogsController::logInsert($error_line,$error_url,$error_log,$type_log);
            $arr = [
                'status' => '500',
                'result' => 'error',
                'message' => 'ไม่สามารถทำรายการได้'
            ];
            echo json_encode($arr);
        }
    }
}
