<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Webpanel\LogsController;
use App\Helpers\Helper;

//=== Model Backend ===
use App\Models\Backend\QustionModel;
use App\Models\Backend\CustomerModel;
use App\Models\Backend\Customer_question_headModel;
use App\Models\Backend\Customer_question_timeModel;
use App\Models\Backend\Customer_question_pointModel;

//=====================

class CustomerController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    protected $prefix = 'front-end';
    // public function checkQuestion($customer_id){
    //     $data = Customer_question_headModel::where(["customer_id"=>$customer_id, "isActive"=>'waiting'])->first();
    //     $arr['status'] = 200;
    //     if($data){
    //         $check = Customer_question_timeModel::where(["customer_id"=>$customer_id, "isActive"=>'waiting'])->first();
    //         if(!$check){
    //             $check = new Customer_question_timeModel();
    //             $check->customer_id = $customer_id;
    //             $check->question_head_id = $data->id;
    //             $check->isActive = 'waiting';
    //             $check->created_by = Helper::cuby($customer_id);
    //             $check->created_at = date('Y-m-d H:i:s');
    //             $check->updated_at = date('Y-m-d H:i:s');
    //             $check->save();
    //         }
    //         $arr['message'] = "Success";
    //         $arr['time_question'] = $check;
    //     }else{
    //         $data = new Customer_question_headModel();
    //         $data->customer_id = $customer_id;
    //         $data->isActive = 'waiting';
    //         $data->created_by = Helper::cuby($customer_id);
    //         $data->created_at = date('Y-m-d H:i:s');
    //         $data->updated_at = date('Y-m-d H:i:s');
    //         if($data->save()){
    //             $data1 = new Customer_question_timeModel();
    //             $data1->customer_id = $customer_id;
    //             $data1->question_head_id = $data->id;
    //             $data1->isActive = 'waiting';
    //             $data1->created_by = Helper::cuby($customer_id);
    //             $data1->created_at = date('Y-m-d H:i:s');
    //             $data1->updated_at = date('Y-m-d H:i:s');
    //             $data1->save();
    //         }
    //         $arr['message'] = "Success";
    //         $arr['time_question'] = $data1;
    //     }
    //     return $arr;
    // }

    public function checkQuestion($customer_id){
        $data = Customer_question_headModel::where(["customer_id"=>$customer_id, "isActive"=>'waiting'])->first();
        if($data){
            $check = Customer_question_timeModel::where(["customer_id"=>$customer_id, "isActive"=>'waiting'])->first();
            if($check){
                // Check เวลา

                if($check->end_datetime_service > date('Y-m-d H:i')){
                    $arr['status'] = 200;
                    $arr['message'] = "Success";
                    $arr['time_question'] = $check;
                }else{
                    $arr['status'] = 500;
                    $arr['message'] = "แบบสอบถามนี้หมดอายุ !";

                    if($check->isActive == 'waiting'){ $check->isActive = 'success'; $check->save(); }
                }
                // if($check->datetime_service <= date('Y-m-d H:i')){
                //     $arr['status'] = 200;
                //     $arr['message'] = "Success";
                //     $arr['time_question'] = $check;
                // }else{
                //     $arr['status'] = 500;
                //     $arr['message'] = "คุณจะสามารถเริ่มทำแบบสอบถามได้ ".date('d/m/Y H:i น.',strtotime('+543 Years',strtotime($check->datetime_service)))."";
                // }
            }else{
                $arr['status'] = 500;
                $arr['message'] = "กรุณาให้ทางพนักงานทำการสร้างแบบสอบถามก่อน !";
            }
           
        }else{
            $arr['status'] = 500;
            $arr['message'] = "กรุณาให้ทางพนักงานทำการสร้างแบบสอบถามก่อน !";
        }
        return $arr;
    }

    public function questionnaire(Request $request)
    {
        // Check ว่ามีอยู่ในระบบไหมที่ยังเป็น waiting
        $customer_id = Auth::guard('user')->id();
        $data = $this->checkQuestion($customer_id);
        
        if($data['status'] == 200){
            $time = $data['time_question'];

            if($request->quest){
                $question = QustionModel::where('sort',$request->quest)->orderby('sort','asc')->first();
            }else{
                $question = QustionModel::orderby('sort','asc')->first();
            }
            $quest_point = Customer_question_pointModel::where(["customer_id"=>$customer_id, "question_id"=>$question->id, "question_time_id"=>$time->id])->first();
            $limit = $question->count();
            $percent = (100 / $limit) * $question->sort;
    
            $typepage = "";
            if($question->type == "vas"){ $typepage = "questionnaire-vas"; }
            else if($question->type == "womac"){ $typepage = "questionnaire-womac"; }
            else if($question->type == "sf12"){ $typepage = "questionnaire-sf12"; }
            return view("$this->prefix.$typepage", [
                'prefix' => $this->prefix,
                'time' => $time,
                'question' => $question,
                'limit' => $limit,
                'percent' => $percent,
                'quest_point' => $quest_point,
            ]);
        }else{
            return view("$this->prefix.alert.alert", [
                'url' => 'home',
                'title' => "ไม่สามารถทำรายการได้",
                'html' => "". $data['message'],
                'icon' => 'error'
            ]);
        }
    }

    public function resultScore(Request $request)
    {
        $customer_id = Auth::guard('user')->id();
        $question = QustionModel::where('isActive','Y')->orderby('sort','desc')->first();
        $time = Customer_question_timeModel::where(["isActive"=>'waiting', "customer_id"=>$customer_id])->first();

        $points = Customer_question_pointModel::where(["question_time_id"=>$time->id])->get();
        $vas_point = 0;
        $womac_point = 0;
        $sf12_point = 0;
        if($points){
            foreach($points as $point){
                $vas_point = $vas_point + $point->vas_point;
                $womac_point = $womac_point + $point->womac_point;
                $sf12_point = $sf12_point + $point->sf12_point;
            }
        }

        $max_point = $vas_point + $womac_point + $sf12_point;

        return view("$this->prefix.result-score", [
            'prefix' => $this->prefix,
            'backpage' => $question->sort,
            'time' => $time,
            'vas_point' => $vas_point,
            'womac_point' => $womac_point,
            'sf12_point' => $sf12_point,
            'max_point' => $max_point,
        ]);
    }

    public function success(Request $request)
    {
        return view("$this->prefix.success", [
            'prefix' => $this->prefix,
        ]);
    }

    public function submitSuccess(Request $request){
        try {
            DB::beginTransaction();
            $customer_id = Auth::guard('user')->id();
            $check = Customer_question_headModel::where(["customer_id"=>$customer_id , "isActive"=> 'waiting'])->first();
            if($check){
                $check->updated_by = Helper::cuby($customer_id);
                if($check->save()){
                    $times = Customer_question_timeModel::where(["customer_id"=>$customer_id, 'question_head_id'=>$check->id, 'isActive'=>'waiting'])->first();
                    if($times){
                        $points = Customer_question_pointModel::where(["customer_id"=>$customer_id, 'question_time_id'=>$times->id])->get();
                        $vas_point = 0;
                        $womac_point = 0;
                        $sf12_point = 0;
                        foreach($points as $point){
                            $vas_point = $vas_point + $point['vas_point'];
                            $womac_point = $womac_point + $point['womac_point'];
                            $sf12_point = $sf12_point + $point['sf12_point'];
                        }
                        $times->vas_point = $vas_point;
                        $times->womac_point = $womac_point;
                        $times->sf12_point = $sf12_point;
                        $times->isActive = "success";
                        $times->updated_by = Helper::cuby($customer_id);
                        if($times->save()){
                            DB::commit();
                            $arr['status'] = 200;
                            $arr['message'] = "ดำเนินการสำเร็จ";
                            $arr['desc'] = "";
                        }else{
                            $arr['status'] = 500;
                            $arr['message'] = "เกิดข้อผิดพลาด";
                            $arr['desc'] = "กรุณาทำรายการใหม่";
                        }
                    }
                }
            }
            return json_encode($arr);
        } catch (\Exception $e) {
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            // $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            return view("$this->prefix.alert.alert", [
                'url' => $error_url,
                'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
                'text' => "กรุณาแจ้งรหัส Code : 1 ให้ทางผู้พัฒนาโปรแกรม ",
                'icon' => 'error'
            ]);
        }
    }
    

    public function questionAnswer(Request $request)
    {
        try {
            DB::beginTransaction();
            $check = Customer_question_pointModel::where(["question_time_id"=> $request->question_time_id, "question_id"=> $request->question_id])->first();
            if ($check == null) {
                $data = new Customer_question_pointModel();
                $data->created_at = date('Y-m-d H:i:s');
                $data->updated_at = date('Y-m-d H:i:s');
                $data->customer_id = Auth::guard('user')->id();
                $data->created_by = Helper::cuby(Auth::guard('user')->id());
                $data->question_time_id = $request->question_time_id;
                $data->question_id = $request->question_id;
            } else {
                $data = Customer_question_pointModel::find($check->id);
                $data->updated_at = date('Y-m-d H:i:s');
            }
            $check_question = QustionModel::find($request->question_id);
            $data->vas_point = 0;
            $data->womac_point = 0;
            $data->sf12_point = 0;
            if($check_question->type == "vas"){
                $data->vas_point = $request->point;
            }
            else if($check_question->type == "womac"){
                $data->womac_point = $request->point;
            }
            else if($check_question->type == "sf12"){
                $data->sf12_point = $request->point;
            }
            if ($data->save()) {
                DB::commit();
                $arr['status'] = 200;
                $arr['message'] = "ดำเนินการสำเร็จ";
                $arr['desc'] = "";
            } else {
                $arr['status'] = 500;
                $arr['message'] = "เกิดข้อผิดพลาด";
                $arr['desc'] = "กรุณาทำรายการใหม่";
            }
            return json_encode($arr);
        } catch (\Exception $e) {
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            // $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            return view("$this->prefix.alert.alert", [
                'url' => $error_url,
                'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
                'text' => "กรุณาแจ้งรหัส Code : 1 ให้ทางผู้พัฒนาโปรแกรม ",
                'icon' => 'error'
            ]);
        }
    }
}
