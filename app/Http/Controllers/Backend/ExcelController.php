<?php

namespace App\Http\Controllers\Backend;

use App\Models\ServCost;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Excel;
use App\Models\SiteInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\GnrRec;
use Auth;


class ExcelController extends Controller
{
    function exportSiteInfo(Request $request)
    {
        $region = $request->get('region');
        $siteinfoDB = new SiteInfo();
        $infoSites = $siteinfoDB->searchInfoSite($region);
        foreach ($infoSites as $infoSite) {
            $servPrice = DB::table('fee_out_site_price')->where('site_code', $infoSite->site_code)->get();
            if (!empty($servPrice)) {
                $infoSite->fee_basic = $servPrice[0]->fee_basic;
                $infoSite->fee_basic_taxed = $servPrice[0]->fee_basic_taxed;
                $infoSite->fee_site = $servPrice[0]->fee_site;
                $infoSite->fee_site_taxed = $servPrice[0]->fee_site_taxed;
                $infoSite->fee_import = $servPrice[0]->fee_import;
                $infoSite->fee_import_taxed = $servPrice[0]->fee_import_taxed;
            }

        }
        foreach ($infoSites as $infoSite) {
            if (empty($infoSite->fee_basic)) {
                $infoSite->fee_basic = '';
            }
            if (empty($infoSite->fee_basic_taxed)) {
                $infoSite->fee_basic_taxed = '';
            }
            if (empty($infoSite->fee_site)) {
                $infoSite->fee_site = '';
            }
            if (empty($infoSite->fee_site_taxed)) {
                $infoSite->fee_site_taxed = '';
            }
            if (empty($infoSite->fee_import)) {
                $infoSite->fee_import = '';
            }
            if (empty($infoSite->fee_import_taxed)) {
                $infoSite->fee_import_taxed = '';
            }
            $export[] = array(
                '站址编码' => $infoSite->site_code,
                '地市' => $infoSite->region_name,
                '产品配套类型' => $infoSite->product_type,
                '是否为新建站' => $infoSite->is_new_tower,
                '是否存在新建共享' => $infoSite->is_newly_added,
                '铁塔类型' => $infoSite->tower_type,
                '系统数量' => $infoSite->sys_num,
                '系统挂高' => $infoSite->sys1_height,
                '覆盖场景' => $infoSite->land_form,
                '共享类型' => $infoSite->share_type,
                '是否为竞合站点' => $infoSite->is_co_opetition,
                '站址所在地区类型' => $infoSite->site_district_type,
                '是否RRU拉远' => $infoSite->is_rru_away,
                '用户类型' => $infoSite->user_type,
                '引电类型（V）' => $infoSite->elec_introduced_type,
                '基准价格（元/天）（不含税）' => $infoSite->fee_basic,
                '基准价格（元/天）（含税）' => $infoSite->fee_basic_taxed,
                '场地费（元/天）（不含税）' => $infoSite->fee_site,
                '场地费（元/天）（含税）' => $infoSite->fee_site_taxed,
                '电力引入费（元/天）（不含税）' => $infoSite->fee_import,
                '电力引入费（元/天）（含税）' => $infoSite->fee_import_taxed,
                '扣费' => '0',
            );
        }
        Excel::create('站址属性信息', function ($excel) use ($export) {
            $excel->sheet('站址属性信息', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
    }

    function exportServCost(Request $request)
    {
        $region = $request->get('region');
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');
        $servCostDB = new ServCost();
        $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
        if (!empty($servCosts)) {
            foreach ($servCosts as $servCost) {
                if (!isset($servCost->fee_basic)) {
                    $servCost->fee_basic = '';
                }
                if (!isset($servCost->fee_basic_taxed)) {
                    $servCost->fee_basic_taxed = '';
                }
                if (!isset($servCost->fee_site)) {
                    $servCost->fee_site = '';
                }
                if (!isset($servCost->fee_site_taxed)) {
                    $servCost->fee_site_taxed = '';
                }
                if (!isset($servCost->fee_import)) {
                    $servCost->fee_import = '';
                }
                if (!isset($servCost->fee_import_taxed)) {
                    $servCost->fee_import_taxed = '';
                }
                if (!isset($servCost->fee_electricity)) {
                    $servCost->fee_electricity = '';
                }
                if (!isset($servCost->fee_electricity_taxed)) {
                    $servCost->fee_electricity_taxed = '';
                }
                $export[] = array(
                    '地市' => $servCost->region_name,
                    '提交时间' => $servCost->created_at,
                    '服务费用日期' => $servCost->month,
                    '站址总数' => $servCost->site_num,
                    '基准价格（万元/不含税）' => $servCost->fee_basic,
                    '基准价格（万元/含税）' => $servCost->fee_basic_taxed,
                    '场地费（万元/不含税）' => $servCost->fee_site,
                    '场地费（万元/含税）' => $servCost->fee_site_taxed,
                    '电力引入费（万元/不含税）' => $servCost->fee_import,
                    '电力引入费（万元/含税）' => $servCost->fee_import_taxed,
                    '日常电费（万元/不含税）' => $servCost->fee_electricity,
                    '日常电费（万元/含税）' => $servCost->fee_electricity_taxed,

                );
            }
            Excel::create('站址服务费用', function ($excel) use ($export) {
                $excel->sheet('站址服务费用', function ($sheet) use ($export) {
                    $sheet->fromArray($export);
                });
            })->export('xls');
        } else {
            echo "<script>history.back()</script>";
        }

    }

    function exportBasicFee(Request $request)
    {
        $basicFees = DB::table('fee_basic_table')->get();
        foreach ($basicFees as $basicFee) {
            $export[] = array(
                '塔型' => $basicFee->tower_type,
                '系统挂高（米）' => $basicFee->sys_height,
                '配套类型' => $basicFee->product_type,
                '是否为新建站' => $basicFee->is_new_tower,
                '基准价格（元/天）（不含税）' => $basicFee->fee_basic,

            );
        }
        Excel::create('基准服务价格标准', function ($excel) use ($export) {
            $excel->sheet('基准服务价格标准', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    function exportSiteFee(Request $request)
    {
        $region = $request->get('region');
        if ($region == '湖北省') {
            $siteFees = DB::table('fee_site_table')->get();
        } else {
            $siteFees = DB::table('fee_site_table')->where('region_name', $region)->get();
        }
        foreach ($siteFees as $siteFee) {
            $export[] = array(
                '地市' => $siteFee->region_name,
                '站址所在地区类型' => $siteFee->site_district_type,
                '是否RRU拉远' => $siteFee->is_rru_away,
                '场地费（元/天）（不含税）' => $siteFee->fee_site,

            );
        }

        Excel::create('场地费价格标准', function ($excel) use ($export) {
            $excel->sheet('场地费价格标准', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    function exportElecImportFee(Request $request)
    {
        $region = $request->get('region');
        if ($region == '湖北省') {
            $elecImportFees = DB::table('fee_import_table')->get();
        } else {
            $elecImportFees = DB::table('fee_import_table')->where('region_name', $region)->get();
        }

        foreach ($elecImportFees as $elecImportFee) {
            $export[] = array(
                '地市' => $elecImportFee->region_name,
                '引电类型' => $elecImportFee->elec_introduced_type,
                '电力引入费（元/天）（不含税）' => $elecImportFee->fee_import,

            );
        }

        Excel::create('电力引入费价格标准', function ($excel) use ($export) {
            $excel->sheet('电力引入费价格标准', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    function exportDiscount(Request $request)
    {
        $feeType = $request->get('fee_type');
        $discounts = DB::table('share_discount')->get();
        foreach ($discounts as $discount) {
            $export[] = array(
                '是否为新建站' => $discount->is_new_tower,
                '共享类型' => $discount->share_type,
                '用户类型' => $discount->user_type,
                '是否存在新增共享' => $discount->is_newly_added,
                '基准价格折扣' => $discount->discount_basic,
                '场地费折扣' => $discount->discount_site,
                '电力引入费折扣' => $discount->discount_import,

            );
        }

        Excel::create('共享折扣', function ($excel) use ($export) {
            $excel->sheet('共享折扣', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    function exportGnrRec(Request $request)
    {
        $region = $request->get('region_export');
        $site_code = $request->get('siteCode_export');
        $gnrRecs = DB::table('fee_out_gnr')->where('region_name',$region)->where('site_code',$site_code)->get();
        if(!empty($gnrRecs)){
            foreach ($gnrRecs as $gnrRec) {
                $export[] = array(
                    '地市' => $gnrRec->region_name,
                    '站址编码' => $gnrRec->site_code,
                    '提交时间' => $gnrRec->created_at,
                    '发电起始时间' => $gnrRec->gnr_start_time,
                    '发电终止时间' => $gnrRec->gnr_stop_time,
                    '发电时长' => $gnrRec->gnr_len,
                    '发电费用（元）（不含税）' => $gnrRec->gnr_fee,
                    '发电费用（元）（含税）' => $gnrRec->gnr_fee_taxed,

                );
            }

            Excel::create('发电信息', function ($excel) use ($export) {
                $excel->sheet('发电信息', function ($sheet) use ($export) {
                    $sheet->fromArray($export);
                });
            })->export('xls');
        }else {
            echo "<script>history.back()</script>";
        }
    }


    public function importSiteInfo(Request $request)
    {
        $filter = $request->all();
        $region = $request->input('region', '');

        $file = $request->file('siteInfoFile');
        if ($region != "请选择...") {
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
                    $siteInfoDB = new SiteInfo();
                    $area_level = Auth::user()->area_level;
                    $siteInfoDB->addInfoSiteByArray($results,$area_level);

                });
                $siteinfoDB = new SiteInfo();
                $infoSites = $siteinfoDB->searchInfoSite($region);
                return view('backend/siteInfo/index')->with('infoSites', $infoSites)
                    ->with('filter', $filter);
            }


        } else {

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
                    $siteInfoDB = new SiteInfo();
                    $area_level = Auth::user()->area_level;
                    $siteInfoDB->addInfoSiteByArray($results,$area_level);
                });
                return view('backend/siteInfo/index')->with('filter', $filter);
            }

        }
    }

    public function bulkUpdateSiteInfo(Request $request)
    {
        $filter = $request->all();
        $region = $request->input('region', '');
        $file = $request->file('siteInfoToUpdateFile');
        if ($region != "请选择...") {
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
                    $area_level = Auth::user()->area_level;
                    $siteInfoDB = new SiteInfo();
                    $siteInfoDB->updateInfoSiteByArray($results, $area_level);

                });
                $siteinfoDB = new SiteInfo();
                $infoSites = $siteinfoDB->searchInfoSite($region);
                return view('backend/siteInfo/index')->with('infoSites', $infoSites)
                    ->with('filter', $filter);
            }


        } else {

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
                    $siteInfoDB = new SiteInfo();
                    $siteInfoDB->addInfoSiteByArray($results);
                });
                return view('backend/siteInfo/index')->with('filter', $filter);
            }

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
