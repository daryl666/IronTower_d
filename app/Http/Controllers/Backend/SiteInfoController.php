<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Models\ServPrice;
use Redirect;
use Session;

class SiteInfoController extends Controller
{
    public function indexPage(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $filter = $request->all();
                $region = $request->input('region', '');
                $siteinfoDB = new SiteInfo();
                $infoSites = $siteinfoDB->searchInfoSite($region);
                return view('backend/siteInfo/index')->with('infoSites', $infoSites)
                    ->with('filter', $filter);
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (!empty(session('infoSites'))){
                $infoSites = $request->session()->pull('infoSites');
                if ($infoSites == 1){
                    $infoSites = null;
                }
                $filter = $request->session()->pull('filter');
                $flag = $request->session()->pull('flag');
                if($flag == 'add'){
                    echo "<script language=javascript>alert('提交成功！');</script>";
                }
                if($flag == 'delete'){
                    echo "<script language=javascript>alert('删除成功！');</script>";
                }
                if($flag == 'update'){
                    echo "<script language=javascript>alert('修改成功！');</script>";
                }
                if($flag == 'import'){
                    echo "<script language=javascript>alert('导入成功！');</script>";
                }

                return view('backend/siteInfo/index')->with('infoSites', $infoSites)
                    ->with('filter', $filter);
            }else{
                return view('backend/siteInfo/index');
            }


        }
    }


    public function editPage($id, $region)
    {
        $siteInfo = DB::table('site_info')->where('id', $id)->get();
        $feeSiteOld = DB::table('fee_out_site_price')
            ->where('site_code',$siteInfo[0]->site_code)
            ->where('is_latest_record','是')
            ->pluck('fee_site');
        return view('backend/siteInfo/edit')
            ->with('siteInfo', $siteInfo[0])
            ->with('feeSiteOld',$feeSiteOld[0])
            ->with('region', $region);

    }

    public function addNewPage($region)
    {
        return view('backend/siteInfo/add_new')->with('region', $region);
    }
    public function addOldPage($region)
    {
        return view('backend/siteInfo/add_old')->with('region', $region);
    }
    //根据输入的站址属性查询对应的code


    //将站址属性和站址的服务费用插入到对应的表中
    public function addNewDB(Request $request)
    {
        $filter = $request->all();
        $region = $request->input('region', '');
        $siteinfoDB = new SiteInfo();
        $bool = $siteinfoDB->addInfoSiteNew($request);
        $infoSites = $siteinfoDB->searchInfoSite($region);
        if ($bool[0] == false) {
            if ($bool[1] == true && $bool[2] == true) {
                return redirect('backend/siteInfo')->with('infoSites',$infoSites)->with('filter',$filter)->with('flag','add');
            } else {
                echo "<script language=javascript>alert('提交失败！');history.back();</script>";
            }
        } else {
            echo "<script language=javascript>alert('该站址已经存在！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }


    }

    public function addOldDB(Request $request)
    {
        $filter = $request->all();
        $region = $request->input('region', '');
        $siteinfoDB = new SiteInfo();
        $bool = $siteinfoDB->addInfoSiteOld($request);
        $infoSites = $siteinfoDB->searchInfoSite($region);
        if ($bool[0] == false) {
            if ($bool[1] == true && $bool[2] == true) {
                return redirect('backend/siteInfo')->with('infoSites',$infoSites)->with('filter',$filter)->with('flag','add');
            } else {
                echo "<script language=javascript>alert('提交失败！');history.back();</script>";
            }
        } else {
            echo "<script language=javascript>alert('该站址已经存在！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }


    }

    public function delete($id, Request $request)
    {
        //$isSuccess = DB::table('site_info')->where('id', $id)->delete();
        $isSuccess1 = DB::table('site_info')->where('site_code',$id)
            ->update(['is_latest_record' =>'否'
            ]);
        $isSuccess2= DB::table('fee_out_site_price')->where('site_code',$id)
            ->update(['is_latest_record' =>'否'
            ]);
        if($isSuccess1 and $isSuccess2)
            $isSuccess=true;
        else
            $isSuccess=false;
        $filter = $request->all();
        $siteinfoDB = new SiteInfo();
        $infoSites = $siteinfoDB->searchInfoSite($request->get('region'));
        if (empty($infoSites)){
            $infoSites = 1;
        }
        if ($isSuccess == true) {
            return redirect('backend/siteInfo')->with('infoSites',$infoSites)->with('filter',$filter)->with('flag','delete');
        } else {
            echo "<script language=javascript>alert('删除失败！');history.back();</script>";
        }


    }

    public function update(Request $request)
    {

        $filter = $request->all();
        $region = $request->input('region', '');
        $siteinfoDB = new SiteInfo();
        $isSuccess = $siteinfoDB->updateDB($request);
        $infoSites = $siteinfoDB->searchInfoSite($region);
        if ($isSuccess == true) {
            return redirect('backend/siteInfo')->with('infoSites',$infoSites)->with('filter',$filter)->with('flag','update');
        } else {
            echo "<script language=javascript>alert('修改失败！');history.back()</script>";
        }


    }

    function back(Request $request){
        $filter = $request->all();
        $region = $request->get('region');
        $siteinfoDB = new SiteInfo();
        $infoSites = $siteinfoDB->searchInfoSite($region);
        return view('backend/siteInfo/index')->with('infoSites', $infoSites)
            ->with('filter', $filter);
    }


    function test(){
        $siteInfo_201610 = DB::table('billing')
            ->where('month','201610')
            ->where('fee_site','!=','0')
            ->get();
        $siteinfo_array = array();
        foreach ($siteInfo_201610 as $siteInfo) {
            $siteInfo_201611 = DB::table('billing')
                ->where('month','201611')
                ->where('site_code',$siteInfo->site_code)
                ->where('fee_site','!=',$siteInfo->fee_site)
                ->get();
            array_push($siteinfo_array,$siteInfo_201611);

        }
        dd(sizeof($siteinfo_array));

    }


}
