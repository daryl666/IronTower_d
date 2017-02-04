<?php

namespace App\Http\Controllers\Backend;

use App\Models\GnrRec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SiteInfo;
use Illuminate\Support\Facades\Session;
use Excel;
use App\Http\Controllers\Controller;

class GnrRecController extends Controller
{

    public function my_sort($arrays, $sort_key, $sort_order = SORT_ASC, $sort_type = SORT_NUMERIC)
    {
//        foreach ($arrays as $array){
//            $array=json_encode($array);
//            $array=json_decode($array,true);
//        }
        if (is_array($arrays)) {
            foreach ($arrays as $array) {

//                dd($array->last_gnr_time);
                $key_arrays[] = $array[$sort_key];
            }
        } else {
            return false;
        }
        array_multisort($key_arrays, $sort_order, $sort_type, $arrays);
        return $arrays;
    }

    public function indexPage_siteinfo(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $filter = $request->all();
            $filter['siteChoose'] = null;
            $region = $request->input('region', '');
            $siteinfoDB = new SiteInfo();
            $gnrrecDB = new GnrRec();
            $siteInfos = $siteinfoDB->searchInfoSite($region);
            if (!empty($siteInfos)) {
                foreach ($siteInfos as $siteInfo) {
                    $gnrRec = $gnrrecDB->searchGnr($siteInfo->site_code);
                    $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteInfo->site_code)->sum('gnr_len_minute');
                    $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
                    $gnr_total_len_minutes = $gnr_total_len_minute % 60;
                    $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
                    $gnr_num = count($gnrRec);
                    $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteInfo->site_code)->sum('gnr_fee');
                    $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteInfo->site_code)->sum('gnr_fee_taxed');
                    if (!empty($gnrRec)) {
                        $siteInfo->last_gnr_time = $gnrRec[0]->gnr_stop_time;
                        $siteInfo->gnr_total_len = $gnr_total_len;
                        $siteInfo->gnr_num = $gnr_num;
                        $siteInfo->gnr_total_fee = $gnr_total_fee;
                        $siteInfo->gnr_total_fee_taxed = $gnr_total_fee_taxed;
                    }
                    if (empty($gnrRec)) {
                        $siteInfo->last_gnr_time = '';
                        $siteInfo->gnr_total_len = '';
                        $siteInfo->gnr_num = '';
                        $siteInfo->gnr_total_fee = '';
                        $siteInfo->gnr_total_fee_taxed = '';
                    }
                }
                $siteInfos = json_encode($siteInfos);
                $siteInfos = json_decode($siteInfos, true);
                $siteInfos = $this->my_sort($siteInfos, 'last_gnr_time', SORT_DESC, SORT_STRING);
                $siteInfos = json_encode($siteInfos);
                $siteInfos = json_decode($siteInfos);
                return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
                    ->with('filter', $filter);
            } else {
                return view('backend/gnrRec/index')
                    ->with('filter', $filter);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            return view('backend/gnrRec/index');
        }


    }

    public function indexPage_gnr(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $filter = $request->all();
            $id = $request->input('siteChoose', '0');
            $siteinfoDB = new SiteInfo();
            $gnrrecDB = new GnrRec();

            $siteInfos = $siteinfoDB->searchInfoSiteById($id);
            $siteCode = $siteInfos[0]->site_code;
            $gnrRecs = $gnrrecDB->searchGnr($siteCode);
            $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
            $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
            $gnr_total_len_minutes = $gnr_total_len_minute % 60;
            $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
            $gnr_num = count($gnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee_taxed');
            if (!empty($gnrRecs)) {
                $siteInfos[0]->last_gnr_time = $gnrRecs[0]->gnr_stop_time;
                $siteInfos[0]->gnr_total_len = $gnr_total_len;
                $siteInfos[0]->gnr_num = $gnr_num;
                $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
                $siteInfos[0]->gnr_total_fee_taxed = $gnr_total_fee_taxed;
            }


            return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
                ->with('filter', $filter)
                ->with('gnrRecs', $gnrRecs);
        } else {
            if (!empty(session('gnrRecs'))) {
                $siteInfos = $request->session()->pull('siteInfos');
                $filter = $request->session()->pull('filter');
                $gnrRecs = $request->session()->pull('gnrRecs');
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language=javascript>alert('提交成功！');</script>";
                } elseif ($flag == 'update') {
                    echo "<script language=javascript>alert('修改成功！');</script>";
                } elseif ($flag == 'delete') {
                    echo "<script language=javascript>alert('删除成功！');</script>";
                } elseif ($flag == 'import') {
                    echo "<script language=javascript>alert('导入成功！');</script>";
                }
                return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
                    ->with('gnrRecs', $gnrRecs)
                    ->with('filter', $filter)
                    ->with('status_update', $filter);
            } else {
                return view('backend/gnrRec/index');
            }
        }


    }

    public function addPage(Request $request)
    {

        $siteChoose = $request->get('sitechoose');
        $siteID = $request->get('siteID');
        $siteInfos = DB::table('site_info')->where('id', $siteID)->get();
        $siteCode = $siteInfos[0]->site_code;
        $gnrrecDB = new GnrRec();
        $gnrRecs = $gnrrecDB->searchGnr($siteCode);
        $siteInfos[0]->site_address = $request->get('siteAddress');
        $siteInfos[0]->last_gnr_time = $request->get('lastGnrTime');
        $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
        $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
        $gnr_total_len_minutes = $gnr_total_len_minute % 60;
        $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
        $gnr_num = count($gnrRecs);
        $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
        $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee_taxed');
        $siteInfos[0]->gnr_total_len = $gnr_total_len;
        $siteInfos[0]->gnr_num = $gnr_num;
        $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
        $siteInfos[0]->gnr_total_fee_taxed = $gnr_total_fee_taxed;
        return view('backend/gnrRec/add')->with('sitechoose', $siteChoose)
            ->with('siteInfos', $siteInfos);
    }

    public function editPage($gnrID, $siteID, $siteChoose, $lastGnrTime)
    {
//        $sitechoose = $request->get('sitechoose');
        $siteInfos = DB::table('site_info')->where('id', $siteID)->get();
        $siteCode = $siteInfos[0]->site_code;
        $gnrRec = DB::table('fee_out_gnr')->where('id', $gnrID)->get();
        $gnrrecDB = new GnrRec();
        $gnrRecs = $gnrrecDB->searchGnr($siteCode);
        $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
        $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
        $gnr_total_len_minutes = $gnr_total_len_minute % 60;
        $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
        $gnr_num = count($gnrRecs);
        $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
        $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee_taxed');
        $siteInfos[0]->gnr_total_len = $gnr_total_len;
        $siteInfos[0]->gnr_num = $gnr_num;
        $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
        $siteInfos[0]->gnr_total_fee_taxed = $gnr_total_fee_taxed;
        $siteInfos[0]->last_gnr_time = $lastGnrTime;
        return view('backend/gnrRec/edit')->with('gnrRecs', $gnrRec)
            ->with('siteInfos', $siteInfos)
            ->with('sitechoose', $siteChoose);
    }

    public function addGnr(Request $request)
    {
        $filter = $request->all();
        $siteCode = $request->get('siteCode');
        $region = $request->get('region');
        $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_latest_record', '是')->get();
        $gnrRecDB = new GnrRec();
        $startTime = $request->get('startTime');
        $stopTime = $request->get('stopTime');
        $siteCode = $request->get('siteCode');
        $gnr_len_minute = floor((strtotime($stopTime) - strtotime($startTime)) / 60);
        $gnr_hour = floor($gnr_len_minute / 60);
        $gnr_minute = $gnr_len_minute % 60;
        $gnr_len = $gnr_hour . ':' . $gnr_minute;
        $gnr_compute_len = $gnr_hour > 5 ? $gnr_hour : 5;
        $land_form = DB::table('site_info')->where('site_code', $siteCode)->pluck('land_form');
        if ($land_form[0] == '山区') {
            $gnr_fee = 270 + 20 * ($gnr_compute_len - 5);
        } elseif ($land_form[0] == '平原') {
            $gnr_fee = 220 + 20 * ($gnr_compute_len - 5);
        }

//        $last_gnr_stop_time = DB::table('fee_out_gnr')->where('site_code', $siteCode)->pluck('last_gnr_stop_time');
//
//        if (!empty($last_gnr_stop_time)) {
//
//            $last_gnr_stop_time = $last_gnr_stop_time[0];
//            if (strtotime($last_gnr_stop_time) < strtotime($stopTime)) {
//                DB::table('fee_out_gnr')->where('site_code', $siteCode)
//                    ->update(['last_gnr_stop_time' => $stopTime]);
//                $last_gnr_stop_time = $stopTime;
//            }
//        } else {
//            $last_gnr_stop_time = $stopTime;
//        }

        $isSuccess = DB::table('fee_out_gnr')
            ->insert(['site_code' => $siteCode,
                'region_name' => $region,
                'gnr_start_time' => $startTime,
                'gnr_stop_time' => $stopTime,
                'gnr_len' => $gnr_len,
                'gnr_len_minute' => $gnr_len_minute,
                'gnr_compute_len' => $gnr_compute_len,
                'gnr_fee' => $gnr_fee,
                'gnr_fee_taxed' => $gnr_fee * 1.06,
//                'last_gnr_stop_time' => $last_gnr_stop_time,
                'created_at' => date('Y-m-d h:i:s', time())]);


        if ($isSuccess == true) {
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
            $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
            $gnr_total_len_minutes = $gnr_total_len_minute % 60;
            $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
            $gnr_num = count($gnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $last_gnr_time = DB::table('fee_out_gnr')->where('site_code', $siteCode)->max('gnr_stop_time');
            $siteInfos[0]->last_gnr_time = $last_gnr_time;
            $siteInfos[0]->gnr_total_len = $gnr_total_len;
            $siteInfos[0]->gnr_num = $gnr_num;
            $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
            return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter)
                ->with('flag', 'add');
        } else {
            echo "<script language=javascript>alert('提交失败！');history.back();</script>";
        }

    }

    public function update(Request $request)
    {
        $filter = $request->all();
        $siteCode = $request->get('siteCode');
        $gnrRecDB = new GnrRec();
        $isSuccess = $gnrRecDB->updateDB($request);
        if ($isSuccess == 'is_out'){
            echo "<script language=javascript>alert('该月账单已出，无法修改！');history.back();</script>";
        }else{
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $lastGnrTime = $gnrRecs[0]->gnr_stop_time;
            if ($isSuccess == true) {
                $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_latest_record', '是')->get();
                $gnrRecs = $gnrRecDB->searchGnr($siteCode);
                $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
                $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
                $gnr_total_len_minutes = $gnr_total_len_minute % 60;
                $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
                $gnr_num = count($gnrRecs);
                $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
                $siteInfos[0]->last_gnr_time = $lastGnrTime;
                $siteInfos[0]->gnr_total_len = $gnr_total_len;
                $siteInfos[0]->gnr_num = $gnr_num;
                $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
                return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
                    ->with('gnrRecs', $gnrRecs)
                    ->with('filter', $filter)
                    ->with('flag', 'update');

            } else {
                echo "<script language=javascript>alert('修改失败！');history.back();</script>";
            }
        }



    }

    public function back(Request $request)
    {
        $filter = $request->all();
        $siteCode = $request->get('siteCode');
        $lastGnrTime = $request->get('lastGnrTime');
        $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->get();
        $siteInfos[0]->last_gnr_time = $lastGnrTime;
        $gnrRecDB = new GnrRec();
        $gnrRecs = $gnrRecDB->searchGnr($siteCode);
        $gnr_total_compute_len = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_compute_len');
        $gnr_num = count($gnrRecs);
        $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
        $siteInfos[0]->gnr_total_compute_len = $gnr_total_compute_len;
        $siteInfos[0]->gnr_num = $gnr_num;
        $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
        return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
            ->with('gnrRecs', $gnrRecs)
            ->with('filter', $filter);
    }

    public function delete($id, Request $request)
    {
        $isSuccess = DB::table('fee_out_gnr')->where('id', $id)->delete();
        $filter = $request->all();
        if ($isSuccess == true) {
            $siteCode = $request->get('siteCode');
            $lastGnrTime = $request->get('lastGnrTime');
            $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_latest_record', '是')->get();
            $siteInfos[0]->last_gnr_time = $lastGnrTime;
            $gnrRecDB = new GnrRec();
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $gnr_total_compute_len = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_compute_len');
            $gnr_num = count($gnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $siteInfos[0]->gnr_total_compute_len = $gnr_total_compute_len;
            $siteInfos[0]->gnr_num = $gnr_num;
            $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
            return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter)
                ->with('flag', 'delete');
        } else {
            echo "<script language=javascript>alert('删除失败！');history.back();</script>";
        }


    }

    public function importGnrRec(Request $request)
    {
        $file = $request->file('gnrRecFile');
        $clientName = $file->getClientOriginalName();
        $file_types = explode(".", $clientName);
        $file_type = $file_types [count($file_types) - 1];
        if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
            echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
        } else {
            $savePath = 'storage/app';
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            $path = $file->move($savePath, $file_name);
            $filePath = "public\storage\app\\";
//        $reader->setOutputEncoding('UTF-8');
            Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                $reader = $reader->getSheet(0);
//            获取表中的数据
                $results = $reader->toArray();
                $gnrRecDB = new GnrRec();
                $gnrRecDB->addGnrRecByArray($results);

            });
            $filter = $request->all();
            $siteCode = $request->get('siteCode');

            $gnrRecDB = new GnrRec();
            $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_latest_record', '是')->get();
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
            $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
            $gnr_total_len_minutes = $gnr_total_len_minute % 60;
            $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
            $gnr_num = count($gnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $last_gnr_time = DB::table('fee_out_gnr')->where('site_code', $siteCode)->max('gnr_stop_time');
            $siteInfos[0]->last_gnr_time = $last_gnr_time;
            $siteInfos[0]->gnr_total_len = $gnr_total_len;
            $siteInfos[0]->gnr_num = $gnr_num;
            $siteInfos[0]->gnr_total_fee = $gnr_total_fee;

            return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter)
                ->with('flag', 'import');
        }

    }
}
