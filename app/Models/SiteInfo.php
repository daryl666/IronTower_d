<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;
use App\Models\ServPrice;

class SiteInfo extends Model
{
    public function searchCode(Request $request)
    {
        $region_id = DB::table('area_info_copy')
            ->where('region_name', '=', $request->get('regionName'))
            ->pluck('region_id');
        $product_type = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('productType'))
            ->pluck('code');
        $rru_away = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('rruAway'))
            ->pluck('code');
        $site_district_type = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('siteDistType'))
            ->pluck('code');
        $sys_height = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('sysHeight'))
            ->pluck('code');
        $tower_type = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('towerType'))
            ->pluck('code');
        $elec_introduced_type
            = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('elecIntroType'))
            ->pluck('code');
        $code = $region_id[0] . $product_type[0] . $rru_away[0] . $site_district_type[0] . $sys_height[0] .
            $tower_type[0] . $elec_introduced_type[0];
        return $code;
    }

    public function addInfoSiteNew(Request $request)
    {
        //插入站址属性信息
        $sysNum = $request->get('sysNum');
        $sysHeight1 = $request->get('sysHeight1');
        $sysHeight2 = $request->get('sysHeight2');
        $sysHeight3 = $request->get('sysHeight3');
        $sysHeight4 = $request->get('sysHeight4');
        $sysHeight5 = $request->get('sysHeight5');
        if ($sysNum == '1') {
            $sysHeight2 = null;
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '2') {
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '3') {
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '4') {
            $sysHeight5 = null;
        }

//        if ($request->get('towerType') == '普通地面塔') {
//            $sysHeight = $request->get('sysHeight1');
//        }
//        if ($request->get('towerType') == '景观塔') {
//            $sysHeight = $request->get('sysHeight2');
//        }
//        if ($request->get('towerType') == '简易塔') {
//            $sysHeight = $request->get('sysHeight3');
//        }
//        if ($request->get('towerType') == '普通楼面塔') {
//            $sysHeight = $request->get('sysHeight4');
//        }
//        if ($request->get('towerType') == '楼面抱杆') {
//            $sysHeight = $request->get('sysHeight4');
//        }
//        if ($request->get('shareType') == '电信独享') {
//            $userType = $request->get('userType1');
//        } else {
//            $userType = $request->get('userType2');
//        }
//        if ($request->get('sysNum') == '1') {
//            $sysHeight[1] = null;
//            $sysHeight[2] = null;
//            $sysHeight[3] = null;
//            $sysHeight[4] = null;
//        }
//        if ($request->get('sysNum') == '2') {
//            $sysHeight[2] = null;
//            $sysHeight[3] = null;
//            $sysHeight[4] = null;
//        }
//        if ($request->get('sysNum') == '3') {
//            $sysHeight[3] = null;
//            $sysHeight[4] = null;
//        }
//        if ($request->get('sysNum') == '4') {
//            $sysHeight[4] = null;
//        }

        $siteIsExist = DB::table('site_info')->where('site_code', $request->get('siteCode'))->where('is_latest_record', '是')->get();
        if (empty($siteIsExist)) {
            $insSiteInfo = DB::table('site_info')->insert(
                ['site_code' => $request->get('siteCode'),
                    'region_name' => $request->get('regionName'),
                    'product_type' => $request->get('productType'),
                    'share_type_tow' => $request->get('shareType_tower'),
                    'share_type_hou' => $request->get('shareType_house'),
                    'share_type_sup' => $request->get('shareType_supporting'),
                    'share_type_main' => $request->get('shareType_maintainence'),
                    'share_type_site' => $request->get('shareType_site'),
                    'share_type_import' => $request->get('shareType_import'),
                    'established_time' => $request->get('establishedTime'),
                    'modify_time' => date('Y-m-d', time()),
                    'is_new_tower' => '是',
                    'is_newly_added' => '否',
                    'is_rru_away' => $request->get('rruAway'),
                    'sys_num' => $request->get('sysNum'),
                    'sys1_height' => $sysHeight1,
                    'sys2_height' => $sysHeight2,
                    'sys3_height' => $sysHeight3,
                    'sys4_height' => $sysHeight4,
                    'sys5_height' => $sysHeight5,
                    'is_co_opetition' => $request->get('isCoOpetition'),
                    'is_latest_record' => '是',
                    'site_district_type' => $request->get('siteDistType'),
                    'tower_type' => $request->get('towerType'),
                    'land_form' => $request->get('landForm'),
                    'user_type' => $request->get('userType'),
                    'elec_introduced_type' => $request->get('elecIntroType'),

                ]);
            if ($sysHeight1 != null) {
                $fee_tow1 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight1)
                    ->where('is_new_tower', '是')
                    ->pluck('fee_tow');
                $fee_hou1 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_hou');
                $fee_sup1 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_sup');
                $fee_main1 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_main');
                $tow_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_tower'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
                $hou_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_house'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
                $sup_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_supporting'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
                $main_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_maintainence'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
            } else {
                $fee_tow1 = 0;
                $fee_hou1 = 0;
                $fee_sup1 = 0;
                $fee_main1 = 0;
                $tow_sha_dis1 = null;
                $hou_sha_dis1 = null;
                $sup_sha_dis1 = null;
                $main_sha_dis1 = null;
            }
            if ($sysHeight2 != null) {
                $fee_tow2 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight2)
                    ->where('is_new_tower', '是')
                    ->pluck('fee_tow');
                $fee_hou2 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_hou');
                $fee_sup2 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_sup');
                $fee_main2 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_main');

            } else {
                $fee_tow2 = 0;
                $fee_hou2 = 0;
                $fee_sup2 = 0;
                $fee_main2 = 0;
            }
            if ($sysHeight3 != null) {
                $fee_tow3 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight3)
                    ->where('is_new_tower', '是')
                    ->pluck('fee_tow');
                $fee_hou3 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_hou');
                $fee_sup3 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_sup');
                $fee_main3 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_main');
            } else {
                $fee_tow3 = 0;
                $fee_hou3 = 0;
                $fee_sup3 = 0;
                $fee_main3 = 0;
            }
            if ($sysHeight4 != null) {
                $fee_tow4 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight4)
                    ->where('is_new_tower', '是')
                    ->pluck('fee_tow');
                $fee_hou4 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_hou');
                $fee_sup4 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_sup');
                $fee_main4 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_main');
            } else {
                $fee_tow4 = 0;
                $fee_hou4 = 0;
                $fee_sup4 = 0;
                $fee_main4 = 0;
            }
            if ($sysHeight5 != null) {
                $fee_tow5 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight5)
                    ->where('is_new_tower', '是')
                    ->pluck('fee_tow');
                $fee_hou5 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_hou');
                $fee_sup5 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_sup');
                $fee_main5 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '是')
                    ->pluck('fee_main');
            } else {
                $fee_tow5 = 0;
                $fee_hou5 = 0;
                $fee_sup5 = 0;
                $fee_main5 = 0;
            }
            if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                $tow_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_tower'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
                $hou_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_house'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
                $sup_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_supporting'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
                $main_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_maintainence'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_basic');
            } else {
                $tow_sha_dis_oth = null;
                $hou_sha_dis_oth = null;
                $sup_sha_dis_oth = null;
                $main_sha_dis_oth = null;
            }

            $fee_site = DB::table('fee_site_table')
                ->where('region_name', $request->get('regionName'))
                ->where('site_district_type', $request->get('siteDistType'))
                ->where('is_rru_away', $request->get('rruAway'))
                ->pluck('fee_site');
            $fee_import = DB::table('fee_import_table')
                ->where('region_name', $request->get('regionName'))
                ->where('elec_introduced_type', $request->get('elecIntroType'))
                ->pluck('fee_import');

            $site_sha_dis = DB::table('share_discount')
                ->where('is_new_tower', '是')
                ->where('share_type', $request->get('shareType_site'))
                ->where('user_type', $request->get('userType'))
                ->where('is_newly_added', '否')
                ->pluck('discount_site');
            $import_sha_dis = DB::table('share_discount')
                ->where('is_new_tower', '是')
                ->where('share_type', $request->get('shareType_import'))
                ->where('user_type', $request->get('userType'))
                ->where('is_newly_added', '否')
                ->pluck('discount_import');
            $fee_tow_disd = $fee_tow1[0] * $tow_sha_dis1[0] +
                ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * $tow_sha_dis_oth[0] * 0.3;
            $fee_hou_disd = $fee_hou1[0] * $hou_sha_dis1[0] +
                ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * $hou_sha_dis_oth[0] * 0.3;
            $fee_sup_disd = $fee_sup1[0] * $sup_sha_dis1[0] +
                ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * $sup_sha_dis_oth[0] * 0.3;
            $fee_main_disd = $fee_main1[0] * $main_sha_dis1[0] +
                ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * $main_sha_dis_oth[0] * 0.3;
            $fee_site_disd = $fee_site[0] * $site_sha_dis[0];
            $fee_import_disd = $fee_import[0] * $import_sha_dis[0];
            $site_price = DB::table('fee_out_site_price')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_latest_record', '是')
                ->get();
            if (empty($site_price)) {
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tow1' => $fee_tow1[0],
                        'fee_hou1' => $fee_hou1[0],
                        'fee_sup1' => $fee_sup1[0],
                        'fee_main1' => $fee_main1[0],
                        'fee_tow2' => $fee_tow2[0] * 0.3,
                        'fee_hou2' => $fee_hou2[0] * 0.3,
                        'fee_sup2' => $fee_sup2[0] * 0.3,
                        'fee_main2' => $fee_main2[0] * 0.3,
                        'fee_tow3' => $fee_tow3[0] * 0.3,
                        'fee_hou3' => $fee_hou3[0] * 0.3,
                        'fee_sup3' => $fee_sup3[0] * 0.3,
                        'fee_main3' => $fee_main3[0] * 0.3,
                        'fee_tow4' => $fee_tow4[0] * 0.3,
                        'fee_hou4' => $fee_hou4[0] * 0.3,
                        'fee_sup4' => $fee_sup4[0] * 0.3,
                        'fee_main4' => $fee_main4[0] * 0.3,
                        'fee_tow5' => $fee_tow5[0] * 0.3,
                        'fee_hou5' => $fee_hou5[0] * 0.3,
                        'fee_sup5' => $fee_sup5[0] * 0.3,
                        'fee_main5' => $fee_main5[0] * 0.3,
                        'fee_tow' => $fee_tow1[0] + ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * 0.3,
                        'fee_hou' => $fee_hou1[0] + ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * 0.3,
                        'fee_sup' => $fee_sup1[0] + ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * 0.3,
                        'fee_main' => $fee_main1[0] + ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * 0.3,
                        'tow_sha_dis1' => $tow_sha_dis1[0],
                        'hou_sha_dis1' => $hou_sha_dis1[0],
                        'sup_sha_dis1' => $sup_sha_dis1[0],
                        'main_sha_dis1' => $main_sha_dis1[0],
                        'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                        'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                        'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                        'main_sha_dis_oth' => $main_sha_dis_oth[0],
                        'fee_tow_disd' => $fee_tow_disd,
                        'fee_hou_disd' => $fee_hou_disd,
                        'fee_sup_disd' => $fee_sup_disd,
                        'fee_main_disd' => $fee_main_disd,
                        'fee_site' => $fee_site[0],
                        'site_sha_dis' => $site_sha_dis[0],
                        'fee_site_disd' => $fee_site_disd,
                        'fee_import' => $fee_import[0],
                        'import_sha_dis' => $import_sha_dis[0],
                        'fee_import_disd' => $fee_import_disd,
                        'is_latest_record' => '是',
                        'modify_time' => date('Y-m-d', time()),
                        'region_name' => $request->get('regionName')
                    ]);
            } else {
                $updSitePrice = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_latest_record', '是')
                    ->update([
                        'is_latest_record' => '否',
//                        'updated_at' => date('Y-m-d h:i:s',time())
                    ]);
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tow1' => $fee_tow1[0],
                        'fee_hou1' => $fee_hou1[0],
                        'fee_sup1' => $fee_sup1[0],
                        'fee_main1' => $fee_main1[0],
                        'fee_tow2' => $fee_tow2[0],
                        'fee_hou2' => $fee_hou2[0],
                        'fee_sup2' => $fee_sup2[0],
                        'fee_main2' => $fee_main2[0],
                        'fee_tow3' => $fee_tow3[0],
                        'fee_hou3' => $fee_hou3[0],
                        'fee_sup3' => $fee_sup3[0],
                        'fee_main3' => $fee_main3[0],
                        'fee_tow4' => $fee_tow4[0],
                        'fee_hou4' => $fee_hou4[0],
                        'fee_sup4' => $fee_sup4[0],
                        'fee_main4' => $fee_main4[0],
                        'fee_tow5' => $fee_tow5[0],
                        'fee_hou5' => $fee_hou5[0],
                        'fee_sup5' => $fee_sup5[0],
                        'fee_main5' => $fee_main5[0],
                        'fee_tow' => $fee_tow1[0] + $fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0],
                        'fee_hou' => $fee_hou1[0] + $fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou4[0],
                        'fee_sup' => $fee_sup1[0] + $fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0],
                        'fee_main' => $fee_main1[0] + $fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0],
                        'tow_sha_dis1' => $tow_sha_dis1[0],
                        'hou_sha_dis1' => $hou_sha_dis1[0],
                        'sup_sha_dis1' => $sup_sha_dis1[0],
                        'main_sha_dis1' => $main_sha_dis1[0],
                        'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                        'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                        'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                        'main_sha_dis_oth' => $main_sha_dis_oth[0],
                        'fee_tow_disd' => $fee_tow_disd,
                        'fee_hou_disd' => $fee_hou_disd,
                        'fee_sup_disd' => $fee_sup_disd,
                        'fee_main_disd' => $fee_main_disd,
                        'fee_site' => $fee_site[0],
                        'site_sha_dis' => $site_sha_dis[0],
                        'fee_site_disd' => $fee_site_disd,
                        'fee_import' => $fee_import[0],
                        'import_sha_dis' => $import_sha_dis[0],
                        'fee_import_disd' => $fee_import_disd,
                        'is_latest_record' => '是',
                        'modify_time' => date('Y-m-d', time()),
                        'region_name' => $request->get('regionName')
                    ]);
            }
            return Array($siteIsExist, $insSiteInfo, $insSitePrice);
        } else {
            return Array($siteIsExist, false, false);
        }

    }

    public function addInfoSiteOld(Request $request)
    {
        //插入站址属性信息
        $sysNum = $request->get('sysNum');
        $sysHeight1 = $request->get('sysHeight1');
        $sysHeight2 = $request->get('sysHeight2');
        $sysHeight3 = $request->get('sysHeight3');
        $sysHeight4 = $request->get('sysHeight4');
        $sysHeight5 = $request->get('sysHeight5');
        if ($sysNum == '1') {
            $sysHeight2 = null;
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '2') {
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '3') {
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '4') {
            $sysHeight5 = null;
        }

//        if ($request->get('towerType') == '普通地面塔') {
//            $sysHeight = $request->get('sysHeight1');
//        }
//        if ($request->get('towerType') == '景观塔') {
//            $sysHeight = $request->get('sysHeight2');
//        }
//        if ($request->get('towerType') == '简易塔') {
//            $sysHeight = $request->get('sysHeight3');
//        }
//        if ($request->get('towerType') == '普通楼面塔') {
//            $sysHeight = $request->get('sysHeight4');
//        }
//        if ($request->get('towerType') == '楼面抱杆') {
//            $sysHeight = $request->get('sysHeight4');
//        }
//        if ($request->get('shareType') == '电信独享') {
//            $userType = $request->get('userType1');
//        } else {
//            $userType = $request->get('userType2');
//        }
//        if ($request->get('sysNum') == '1') {
//            $sysHeight[1] = null;
//            $sysHeight[2] = null;
//            $sysHeight[3] = null;
//            $sysHeight[4] = null;
//        }
//        if ($request->get('sysNum') == '2') {
//            $sysHeight[2] = null;
//            $sysHeight[3] = null;
//            $sysHeight[4] = null;
//        }
//        if ($request->get('sysNum') == '3') {
//            $sysHeight[3] = null;
//            $sysHeight[4] = null;
//        }
//        if ($request->get('sysNum') == '4') {
//            $sysHeight[4] = null;
//        }

        $siteIsExist = DB::table('site_info')->where('site_code', $request->get('siteCode'))->where('is_latest_record', '是')->get();
        if (empty($siteIsExist)) {
            $insSiteInfo = DB::table('site_info')->insert(
                ['site_code' => $request->get('siteCode'),
                    'region_name' => $request->get('regionName'),
                    'product_type' => $request->get('productType'),
                    'share_type_tow' => $request->get('shareType_tower'),
                    'share_type_hou' => $request->get('shareType_house'),
                    'share_type_sup' => $request->get('shareType_supporting'),
                    'share_type_main' => $request->get('shareType_maintainence'),
                    'share_type_site' => $request->get('shareType_site'),
                    'share_type_import' => $request->get('shareType_import'),
                    'is_new_tower' => '否',
                    'is_newly_added' => $request->get('isNewlyAdded'),
                    'is_rru_away' => null,
                    'established_time' => $request->get('establishedTime'),
                    'modify_time' => date('Y-m-d', time()),
                    'sys_num' => $request->get('sysNum'),
                    'sys1_height' => $sysHeight1,
                    'sys2_height' => $sysHeight2,
                    'sys3_height' => $sysHeight3,
                    'sys4_height' => $sysHeight4,
                    'sys5_height' => $sysHeight5,
                    'is_co_opetition' => $request->get('isCoOpetition'),
                    'is_latest_record' => '是',
                    'site_district_type' => null,
                    'tower_type' => $request->get('towerType'),
                    'land_form' => $request->get('landForm'),
                    'user_type' => $request->get('userType'),
                    'elec_introduced_type' => null,

                ]);
            if ($sysHeight1 != null) {
                $fee_tow1 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight1)
                    ->where('is_new_tower', '否')
                    ->pluck('fee_tow');
                $fee_hou1 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_hou');
                $fee_sup1 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_sup');
                $fee_main1 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_main');
                $tow_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_tower'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', $request->get('isNewlyAdded'))
                    ->pluck('discount_basic');
                $hou_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_house'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', $request->get('isNewlyAdded'))
                    ->pluck('discount_basic');
                $sup_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_supporting'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', $request->get('isNewlyAdded'))
                    ->pluck('discount_basic');
                $main_sha_dis1 = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_maintainence'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', $request->get('isNewlyAdded'))
                    ->pluck('discount_basic');
            } else {
                $fee_tow1 = 0;
                $fee_hou1 = 0;
                $fee_sup1 = 0;
                $fee_main1 = 0;
                $tow_sha_dis1 = null;
                $hou_sha_dis1 = null;
                $sup_sha_dis1 = null;
                $main_sha_dis1 = null;
            }
            if ($sysHeight2 != null) {
                $fee_tow2 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight2)
                    ->where('is_new_tower', '否')
                    ->pluck('fee_tow');
                $fee_hou2 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_hou');
                $fee_sup2 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_sup');
                $fee_main2 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_main');

            } else {
                $fee_tow2 = 0;
                $fee_hou2 = 0;
                $fee_sup2 = 0;
                $fee_main2 = 0;
            }
            if ($sysHeight3 != null) {
                $fee_tow3 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight3)
                    ->where('is_new_tower', '否')
                    ->pluck('fee_tow');
                $fee_hou3 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_hou');
                $fee_sup3 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_sup');
                $fee_main3 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_main');
            } else {
                $fee_tow3 = 0;
                $fee_hou3 = 0;
                $fee_sup3 = 0;
                $fee_main3 = 0;
            }
            if ($sysHeight4 != null) {
                $fee_tow4 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight4)
                    ->where('is_new_tower', '否')
                    ->pluck('fee_tow');
                $fee_hou4 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_hou');
                $fee_sup4 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_sup');
                $fee_main4 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_main');
            } else {
                $fee_tow4 = 0;
                $fee_hou4 = 0;
                $fee_sup4 = 0;
                $fee_main4 = 0;
            }
            if ($sysHeight5 != null) {
                $fee_tow5 = DB::table('fee_tow_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('sys_height', $sysHeight5)
                    ->where('is_new_tower', '否')
                    ->pluck('fee_tow');
                $fee_hou5 = DB::table('fee_hou_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_hou');
                $fee_sup5 = DB::table('fee_sup_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_sup');
                $fee_main5 = DB::table('fee_main_table')
                    ->where('tower_type', $request->get('towerType'))
                    ->where('product_type', $request->get('productType'))
                    ->where('is_new_tower', '否')
                    ->pluck('fee_main');
            } else {
                $fee_tow5 = 0;
                $fee_hou5 = 0;
                $fee_sup5 = 0;
                $fee_main5 = 0;
            }
            if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                $tow_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_tower'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '是')
                    ->pluck('discount_basic');
                $hou_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_house'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '是')
                    ->pluck('discount_basic');
                $sup_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_supporting'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '是')
                    ->pluck('discount_basic');
                $main_sha_dis_oth = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_maintainence'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '是')
                    ->pluck('discount_basic');
            } else {
                $tow_sha_dis_oth = null;
                $hou_sha_dis_oth = null;
                $sup_sha_dis_oth = null;
                $main_sha_dis_oth = null;
            }

            $fee_site = $request->get('feeSiteOld');
            $fee_import = 0;

            $site_sha_dis = DB::table('share_discount')
                ->where('is_new_tower', '否')
                ->where('share_type', $request->get('shareType_site'))
                ->where('user_type', $request->get('userType'))
                ->where('is_newly_added', $request->get('isNewlyAdded'))
                ->pluck('discount_site');
            $import_sha_dis = DB::table('share_discount')
                ->where('is_new_tower', '否')
                ->where('share_type', $request->get('shareType_import'))
                ->where('user_type', $request->get('userType'))
                ->where('is_newly_added', $request->get('isNewlyAdded'))
                ->pluck('discount_import');
            $fee_tow_disd = $fee_tow1[0] * $tow_sha_dis1[0] +
                ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * $tow_sha_dis_oth[0] * 0.3;
            $fee_hou_disd = $fee_hou1[0] * $hou_sha_dis1[0] +
                ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * $hou_sha_dis_oth[0] * 0.3;
            $fee_sup_disd = $fee_sup1[0] * $sup_sha_dis1[0] +
                ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * $sup_sha_dis_oth[0] * 0.3;
            $fee_main_disd = $fee_main1[0] * $main_sha_dis1[0] +
                ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * $main_sha_dis_oth[0] * 0.3;
            $fee_site_disd = $fee_site * $site_sha_dis[0];
            $fee_import_disd = $fee_import * $import_sha_dis[0];
            $site_price = DB::table('fee_out_site_price')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_latest_record', '是')
                ->get();
            if (empty($site_price)) {
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tow1' => $fee_tow1[0],
                        'fee_hou1' => $fee_hou1[0],
                        'fee_sup1' => $fee_sup1[0],
                        'fee_main1' => $fee_main1[0],
                        'fee_tow2' => $fee_tow2[0] * 0.3,
                        'fee_hou2' => $fee_hou2[0] * 0.3,
                        'fee_sup2' => $fee_sup2[0] * 0.3,
                        'fee_main2' => $fee_main2[0] * 0.3,
                        'fee_tow3' => $fee_tow3[0] * 0.3,
                        'fee_hou3' => $fee_hou3[0] * 0.3,
                        'fee_sup3' => $fee_sup3[0] * 0.3,
                        'fee_main3' => $fee_main3[0] * 0.3,
                        'fee_tow4' => $fee_tow4[0] * 0.3,
                        'fee_hou4' => $fee_hou4[0] * 0.3,
                        'fee_sup4' => $fee_sup4[0] * 0.3,
                        'fee_main4' => $fee_main4[0] * 0.3,
                        'fee_tow5' => $fee_tow5[0] * 0.3,
                        'fee_hou5' => $fee_hou5[0] * 0.3,
                        'fee_sup5' => $fee_sup5[0] * 0.3,
                        'fee_main5' => $fee_main5[0] * 0.3,
                        'fee_tow' => $fee_tow1[0] + ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * 0.3,
                        'fee_hou' => $fee_hou1[0] + ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * 0.3,
                        'fee_sup' => $fee_sup1[0] + ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * 0.3,
                        'fee_main' => $fee_main1[0] + ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * 0.3,
                        'tow_sha_dis1' => $tow_sha_dis1[0],
                        'hou_sha_dis1' => $hou_sha_dis1[0],
                        'sup_sha_dis1' => $sup_sha_dis1[0],
                        'main_sha_dis1' => $main_sha_dis1[0],
                        'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                        'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                        'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                        'main_sha_dis_oth' => $main_sha_dis_oth[0],
                        'fee_tow_disd' => $fee_tow_disd,
                        'fee_hou_disd' => $fee_hou_disd,
                        'fee_sup_disd' => $fee_sup_disd,
                        'fee_main_disd' => $fee_main_disd,
                        'fee_site' => $fee_site,
                        'site_sha_dis' => $site_sha_dis[0],
                        'fee_site_disd' => $fee_site_disd,
                        'fee_import' => $fee_import,
                        'import_sha_dis' => $import_sha_dis[0],
                        'fee_import_disd' => $fee_import_disd,
                        'is_latest_record' => '是',
                        'modify_time' => date('Y-m-d', time()),
                        'region_name' => $request->get('regionName')
                    ]);
            } else {
                $updSitePrice = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_latest_record', '是')
                    ->update([
                        'is_latest_record' => '否',
//                        'updated_at' => date('Y-m-d h:i:s',time())
                    ]);
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tow1' => $fee_tow1[0],
                        'fee_hou1' => $fee_hou1[0],
                        'fee_sup1' => $fee_sup1[0],
                        'fee_main1' => $fee_main1[0],
                        'fee_tow2' => $fee_tow2[0],
                        'fee_hou2' => $fee_hou2[0],
                        'fee_sup2' => $fee_sup2[0],
                        'fee_main2' => $fee_main2[0],
                        'fee_tow3' => $fee_tow3[0],
                        'fee_hou3' => $fee_hou3[0],
                        'fee_sup3' => $fee_sup3[0],
                        'fee_main3' => $fee_main3[0],
                        'fee_tow4' => $fee_tow4[0],
                        'fee_hou4' => $fee_hou4[0],
                        'fee_sup4' => $fee_sup4[0],
                        'fee_main4' => $fee_main4[0],
                        'fee_tow5' => $fee_tow5[0],
                        'fee_hou5' => $fee_hou5[0],
                        'fee_sup5' => $fee_sup5[0],
                        'fee_main5' => $fee_main5[0],
                        'fee_tow' => $fee_tow1[0] + $fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0],
                        'fee_hou' => $fee_hou1[0] + $fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou4[0],
                        'fee_sup' => $fee_sup1[0] + $fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0],
                        'fee_main' => $fee_main1[0] + $fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0],
                        'tow_sha_dis1' => $tow_sha_dis1[0],
                        'hou_sha_dis1' => $hou_sha_dis1[0],
                        'sup_sha_dis1' => $sup_sha_dis1[0],
                        'main_sha_dis1' => $main_sha_dis1[0],
                        'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                        'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                        'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                        'main_sha_dis_oth' => $main_sha_dis_oth[0],
                        'fee_tow_disd' => $fee_tow_disd,
                        'fee_hou_disd' => $fee_hou_disd,
                        'fee_sup_disd' => $fee_sup_disd,
                        'fee_main_disd' => $fee_main_disd,
                        'fee_site' => $fee_site,
                        'site_sha_dis' => $site_sha_dis[0],
                        'fee_site_disd' => $fee_site_disd,
                        'fee_import' => $fee_import[0],
                        'import_sha_dis' => $import_sha_dis[0],
                        'fee_import_disd' => $fee_import_disd,
                        'is_latest_record' => '是',
                        'modify_time' => date('Y-m-d', time()),
                        'region_name' => $request->get('regionName')
                    ]);
            }
            return Array($siteIsExist, $insSiteInfo, $insSitePrice);
        } else {
            return Array($siteIsExist, false, false);
        }

    }

    public function addInfoSiteByArray(Array $infoSites, $area_level)
    {
        if ($area_level == 'admin' || $area_level == '湖北省') {
            for ($i = 1; $i < count($infoSites); $i++) {
                $infoSite = DB::table('site_info')->where('site_code', $infoSites[$i][0])->where('is_latest_record', '是')->get();
                if (empty($infoSite)) {
                    DB::table('site_info')->insert([
                        'site_code' => $infoSites[$i][0],
                        'region_name' => $infoSites[$i][1],
                        'product_type' => $infoSites[$i][2],
                        'is_new_tower' => $infoSites[$i][3],
                        'is_newly_added' => $infoSites[$i][4],
                        'tower_type' => $infoSites[$i][5],
                        'sys_num' => $infoSites[$i][6],
                        'sys1_height' => $infoSites[$i][7],
                        'land_form' => $infoSites[$i][8],
                        'share_type' => $infoSites[$i][9],
                        'is_co_opetition' => $infoSites[$i][10],
                        'site_district_type' => $infoSites[$i][11],
                        'is_rru_away' => $infoSites[$i][12],
                        'user_type' => $infoSites[$i][13],
                        'elec_introduced_type' => $infoSites[$i][14],
                        'is_latest_record' => '是',
                    ]);
                }
//                else{
//                    DB::table('site_info')->where('id',$infoSite[0]->id)->update([
//                        'is_latest_record' => '否'
//                    ]);
//                    DB::table('site_info')->insert([
//                        'site_code' => $infoSites[$i][0],
//                        'region_name' => $infoSites[$i][1],
//                        'product_type' => $infoSites[$i][2],
//                        'is_new_tower' => $infoSites[$i][3],
//                        'is_newly_added' => $infoSites[$i][4],
//                        'tower_type' => $infoSites[$i][5],
//                        'sys_num' => $infoSites[$i][6],
//                        'sys1_height' => $infoSites[$i][7],
//                        'land_form' => $infoSites[$i][8],
//                        'share_type' => $infoSites[$i][9],
//                        'is_co_opetition' => $infoSites[$i][10],
//                        'site_district_type' => $infoSites[$i][11],
//                        'is_rru_away' => $infoSites[$i][12],
//                        'user_type' => $infoSites[$i][13],
//                        'elec_introduced_type' => $infoSites[$i][14],
//                        'is_latest_record' => '是',
//                    ]);
//                }

            }
        } else {
            for ($i = 1; $i < count($infoSites); $i++) {
                if ($infoSites[$i][1] == $area_level) {
                    $infoSite = DB::table('site_info')->where('site_code', $infoSites[$i][0])->where('is_latest_record', '是')->where('region_name', $area_level)->get();
                    if (empty($infoSite)) {
                        DB::table('site_info')->insert([
                            'site_code' => $infoSites[$i][0],
                            'region_name' => $infoSites[$i][1],
                            'product_type' => $infoSites[$i][2],
                            'is_new_tower' => $infoSites[$i][3],
                            'is_newly_added' => $infoSites[$i][4],
                            'tower_type' => $infoSites[$i][5],
                            'sys_num' => $infoSites[$i][6],
                            'sys1_height' => $infoSites[$i][7],
                            'land_form' => $infoSites[$i][8],
                            'share_type' => $infoSites[$i][9],
                            'is_co_opetition' => $infoSites[$i][10],
                            'site_district_type' => $infoSites[$i][11],
                            'is_rru_away' => $infoSites[$i][12],
                            'user_type' => $infoSites[$i][13],
                            'elec_introduced_type' => $infoSites[$i][14],
                            'is_latest_record' => '是',
                        ]);
                    }
//                    else {
//                        DB::table('site_info')->where('id', $infoSite[0]->id)->update([
//                            'is_latest_record' => '否'
//                        ]);
//                        DB::table('site_info')->insert([
//                            'site_code' => $infoSites[$i][0],
//                            'region_name' => $infoSites[$i][1],
//                            'product_type' => $infoSites[$i][2],
//                            'is_new_tower' => $infoSites[$i][3],
//                            'is_newly_added' => $infoSites[$i][4],
//                            'tower_type' => $infoSites[$i][5],
//                            'sys_num' => $infoSites[$i][6],
//                            'sys1_height' => $infoSites[$i][7],
//                            'land_form' => $infoSites[$i][8],
//                            'share_type' => $infoSites[$i][9],
//                            'is_co_opetition' => $infoSites[$i][10],
//                            'site_district_type' => $infoSites[$i][11],
//                            'is_rru_away' => $infoSites[$i][12],
//                            'user_type' => $infoSites[$i][13],
//                            'elec_introduced_type' => $infoSites[$i][14],
//                            'is_latest_record' => '是',
//                        ]);
//                    }
                }

            }
        }

    }

    public function updateInfoSiteByArray(Array $infoSites, $area_level)
    {
        if ($area_level == 'admin' || $area_level == '湖北省') {
            for ($i = 1; $i < count($infoSites); $i++) {
                $infoSite = DB::table('site_info')->where('site_code', $infoSites[$i][0])->where('is_latest_record', '是')->get();
                if (empty($infoSite)) {
                    DB::table('site_info')->insert([
                        'site_code' => $infoSites[$i][0],
                        'region_name' => $infoSites[$i][1],
                        'product_type' => $infoSites[$i][2],
                        'is_new_tower' => $infoSites[$i][3],
                        'is_newly_added' => $infoSites[$i][4],
                        'tower_type' => $infoSites[$i][5],
                        'sys_num' => $infoSites[$i][6],
                        'sys1_height' => $infoSites[$i][7],
                        'land_form' => $infoSites[$i][8],
                        'share_type' => $infoSites[$i][9],
                        'is_co_opetition' => $infoSites[$i][10],
                        'site_district_type' => $infoSites[$i][11],
                        'is_rru_away' => $infoSites[$i][12],
                        'user_type' => $infoSites[$i][13],
                        'elec_introduced_type' => $infoSites[$i][14],
                        'is_latest_record' => '是',
                    ]);
                } else {
                    DB::table('site_info')->where('id', $infoSite[0]->id)->update([
                        'is_latest_record' => '否'
                    ]);
                    DB::table('site_info')->insert([
                        'site_code' => $infoSites[$i][0],
                        'region_name' => $infoSites[$i][1],
                        'product_type' => $infoSites[$i][2],
                        'is_new_tower' => $infoSites[$i][3],
                        'is_newly_added' => $infoSites[$i][4],
                        'tower_type' => $infoSites[$i][5],
                        'sys_num' => $infoSites[$i][6],
                        'sys1_height' => $infoSites[$i][7],
                        'land_form' => $infoSites[$i][8],
                        'share_type' => $infoSites[$i][9],
                        'is_co_opetition' => $infoSites[$i][10],
                        'site_district_type' => $infoSites[$i][11],
                        'is_rru_away' => $infoSites[$i][12],
                        'user_type' => $infoSites[$i][13],
                        'elec_introduced_type' => $infoSites[$i][14],
                        'is_latest_record' => '是',
                    ]);
                }

            }
        } else {
            for ($i = 1; $i < count($infoSites); $i++) {
                if ($infoSites[$i][1] == $area_level) {
                    $infoSite = DB::table('site_info')->where('site_code', $infoSites[$i][0])->where('is_latest_record', '是')->where('region_name', $area_level)->get();
                    if (empty($infoSite)) {
                        DB::table('site_info')->insert([
                            'site_code' => $infoSites[$i][0],
                            'region_name' => $infoSites[$i][1],
                            'product_type' => $infoSites[$i][2],
                            'is_new_tower' => $infoSites[$i][3],
                            'is_newly_added' => $infoSites[$i][4],
                            'tower_type' => $infoSites[$i][5],
                            'sys_num' => $infoSites[$i][6],
                            'sys1_height' => $infoSites[$i][7],
                            'land_form' => $infoSites[$i][8],
                            'share_type' => $infoSites[$i][9],
                            'is_co_opetition' => $infoSites[$i][10],
                            'site_district_type' => $infoSites[$i][11],
                            'is_rru_away' => $infoSites[$i][12],
                            'user_type' => $infoSites[$i][13],
                            'elec_introduced_type' => $infoSites[$i][14],
                            'is_latest_record' => '是',
                        ]);
                    } else {
                        DB::table('site_info')->where('id', $infoSite[0]->id)->update([
                            'is_latest_record' => '否'
                        ]);
                        DB::table('site_info')->insert([
                            'site_code' => $infoSites[$i][0],
                            'region_name' => $infoSites[$i][1],
                            'product_type' => $infoSites[$i][2],
                            'is_new_tower' => $infoSites[$i][3],
                            'is_newly_added' => $infoSites[$i][4],
                            'tower_type' => $infoSites[$i][5],
                            'sys_num' => $infoSites[$i][6],
                            'sys1_height' => $infoSites[$i][7],
                            'land_form' => $infoSites[$i][8],
                            'share_type' => $infoSites[$i][9],
                            'is_co_opetition' => $infoSites[$i][10],
                            'site_district_type' => $infoSites[$i][11],
                            'is_rru_away' => $infoSites[$i][12],
                            'user_type' => $infoSites[$i][13],
                            'elec_introduced_type' => $infoSites[$i][14],
                            'is_latest_record' => '是',
                        ]);
                    }
                }

            }
        }

    }

    public function addSiteMonthlyRent(Request $request)
    {
        $code = $this->searchCode($request);

        //根据code查询服务费用
        $site_fee = DB::table('dict_site_std_rent')
            ->where('code', '=', $code)
            ->pluck('site_fee');
        $elec_introduced_fee = DB::table('dict_site_std_rent')
            ->where('code', '=', $code)
            ->pluck('elec_introduced_fee');
        $sys_basic_fee = DB::table('dict_site_std_rent')
            ->where('code', '=', $code)
            ->pluck('basic_fee');

        //插入服务费用信息
        $bool2 = DB::table('fee_site_monthly_rent')->insert(
            ['site_code' => $request->get('siteCode'),
                'site_fee' => $site_fee[0],
                'sys1_basic_fee' => $sys_basic_fee[0],
                'elec_introduced_fee' => $elec_introduced_fee[0]]
        );
    }

    public function searchInfoSiteById($id)
    {
        $query = DB::table('site_info')
            ->where('id', $id)
            ->where('is_latest_record', '是');
        return $query->get();
    }

    public function searchInfoSite($region)
    {
//        dd($region);
        if ($region != '湖北省') {
            //$query = DB::table('site_info')->where('region_name', $region)->orderBy('site_code','ASC')->get();
            $query = DB::table('site_info')->where('region_name', $region)->where('is_latest_record', '是')->get();
        } else {
            //$query = DB::table('site_info')->orderBy('site_code','ASC')->get();
            $query = DB::table('site_info')->where('is_latest_record', '是')->get();
        }


        $servPriceDB = new ServPrice();
        foreach ($query as $infoSite) {
            $servPrice = $servPriceDB->searchServPriceBySiteCode($infoSite->site_code);
            if (isset($servPrice[0])) {
                $infoSite->fee_tow = $servPrice[0]->fee_tow;
//                $infoSite->tow_sha_dis = $servPrice[0]->tow_sha_dis;
                $infoSite->fee_tow_disd = $servPrice[0]->fee_tow_disd;
                $infoSite->fee_hou = $servPrice[0]->fee_hou;
//                $infoSite->hou_sha_dis = $servPrice[0]->hou_sha_dis;
                $infoSite->fee_hou_disd = $servPrice[0]->fee_hou_disd;

                $infoSite->fee_sup = $servPrice[0]->fee_sup;
//                $infoSite->sup_sha_dis = $servPrice[0]->sup_sha_dis;
                $infoSite->fee_sup_disd = $servPrice[0]->fee_sup_disd;
                $infoSite->fee_main = $servPrice[0]->fee_main;

//                $infoSite->main_sha_dis = $servPrice[0]->main_sha_dis;
                $infoSite->fee_main_disd = $servPrice[0]->fee_main_disd;
                $infoSite->fee_site = $servPrice[0]->fee_site;
//                $infoSite->site_sha_dis = $servPrice[0]->site_sha_dis;

                $infoSite->fee_site_disd = $servPrice[0]->fee_site_disd;
                $infoSite->fee_import = $servPrice[0]->fee_import;
//                $infoSite->import_sha_dis = $servPrice[0]->import_sha_dis;
                $infoSite->fee_import_disd = $servPrice[0]->fee_import_disd;
            }

        }
        return $query;
    }

    public function updateDB(Request $request)
    {
        $sysNum = $request->get('sysNum');
        $sysHeight1 = $request->get('sysHeight1');
        $sysHeight2 = $request->get('sysHeight2');
        $sysHeight3 = $request->get('sysHeight3');
        $sysHeight4 = $request->get('sysHeight4');
        $sysHeight5 = $request->get('sysHeight5');
        if ($sysNum == '1') {
            $sysHeight2 = null;
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '2') {
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '3') {
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '4') {
            $sysHeight5 = null;
        }
        $fee_tow1 = DB::table('fee_tow_table')
            ->where('tower_type', $request->get('towerType'))
            ->where('sys_height', $sysHeight1)
            ->where('is_new_tower', '是')
            ->pluck('fee_tow');
        if ($fee_tow1) {
            $establishedTime = DB::table('site_info')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_latest_record', '是')
                ->pluck('established_time');
            $updSiteInfo = DB::table('site_info')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_latest_record', '是')
                ->update(['is_latest_record' => '否'
                ]);


            if ($request->get('isNewTower') == '是') {
                $insSiteInfo = DB::table('site_info')->insert(
                    ['site_code' => $request->get('siteCode'),
                        'region_name' => $request->get('regionName'),
                        'product_type' => $request->get('productType'),
                        'share_type_tow' => $request->get('shareType_tower'),
                        'share_type_hou' => $request->get('shareType_house'),
                        'share_type_sup' => $request->get('shareType_supporting'),
                        'share_type_main' => $request->get('shareType_maintainence'),
                        'share_type_site' => $request->get('shareType_site'),
                        'share_type_import' => $request->get('shareType_import'),
                        'is_new_tower' => '是',
                        'is_newly_added' => '否',
                        'established_time' => $establishedTime[0],
                        'modify_time' => $request->get('modifyTime'),
                        'is_rru_away' => $request->get('rruAway'),
                        'sys_num' => $request->get('sysNum'),
                        'sys1_height' => $sysHeight1,
                        'sys2_height' => $sysHeight2,
                        'sys3_height' => $sysHeight3,
                        'sys4_height' => $sysHeight4,
                        'sys5_height' => $sysHeight5,
                        'is_co_opetition' => $request->get('isCoOpetition'),
                        'is_latest_record' => '是',
                        'site_district_type' => $request->get('siteDistType'),
                        'tower_type' => $request->get('towerType'),
                        'land_form' => $request->get('landForm'),
                        'user_type' => $request->get('userType'),
                        'elec_introduced_type' => $request->get('elecIntroType'),

                    ]);


                if ($sysHeight1 != null) {
                    $fee_tow1 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight1)
                        ->where('is_new_tower', '是')
                        ->pluck('fee_tow');
                    $fee_hou1 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_hou');
                    $fee_sup1 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_sup');
                    $fee_main1 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_main');
                    $tow_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_tower'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                    $hou_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_house'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                    $sup_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_supporting'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                    $main_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_maintainence'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                } else {
                    $fee_tow1 = 0;
                    $fee_hou1 = 0;
                    $fee_sup1 = 0;
                    $fee_main1 = 0;
                    $tow_sha_dis1 = null;
                    $hou_sha_dis1 = null;
                    $sup_sha_dis1 = null;
                    $main_sha_dis1 = null;
                }
                if ($sysHeight2 != null) {
                    $fee_tow2 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight2)
                        ->where('is_new_tower', '是')
                        ->pluck('fee_tow');
                    $fee_hou2 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_hou');
                    $fee_sup2 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_sup');
                    $fee_main2 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_main');

                } else {
                    $fee_tow2 = 0;
                    $fee_hou2 = 0;
                    $fee_sup2 = 0;
                    $fee_main2 = 0;
                }
                if ($sysHeight3 != null) {
                    $fee_tow3 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight3)
                        ->where('is_new_tower', '是')
                        ->pluck('fee_tow');
                    $fee_hou3 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_hou');
                    $fee_sup3 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_sup');
                    $fee_main3 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_main');
                } else {
                    $fee_tow3 = 0;
                    $fee_hou3 = 0;
                    $fee_sup3 = 0;
                    $fee_main3 = 0;
                }
                if ($sysHeight4 != null) {
                    $fee_tow4 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight4)
                        ->where('is_new_tower', '是')
                        ->pluck('fee_tow');
                    $fee_hou4 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_hou');
                    $fee_sup4 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_sup');
                    $fee_main4 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_main');
                } else {
                    $fee_tow4 = 0;
                    $fee_hou4 = 0;
                    $fee_sup4 = 0;
                    $fee_main4 = 0;
                }
                if ($sysHeight5 != null) {
                    $fee_tow5 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight5)
                        ->where('is_new_tower', '是')
                        ->pluck('fee_tow');
                    $fee_hou5 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_hou');
                    $fee_sup5 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_sup');
                    $fee_main5 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '是')
                        ->pluck('fee_main');
                } else {
                    $fee_tow5 = 0;
                    $fee_hou5 = 0;
                    $fee_sup5 = 0;
                    $fee_main5 = 0;
                }
                if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                    $tow_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_tower'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                    $hou_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_house'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                    $sup_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_supporting'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                    $main_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '是')
                        ->where('share_type', $request->get('shareType_maintainence'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', '否')
                        ->pluck('discount_basic');
                } else {
                    $tow_sha_dis_oth = null;
                    $hou_sha_dis_oth = null;
                    $sup_sha_dis_oth = null;
                    $main_sha_dis_oth = null;
                }

                $fee_site = DB::table('fee_site_table')
                    ->where('region_name', $request->get('regionName'))
                    ->where('site_district_type', $request->get('siteDistType'))
                    ->where('is_rru_away', $request->get('rruAway'))
                    ->pluck('fee_site');
                $fee_import = DB::table('fee_import_table')
                    ->where('region_name', $request->get('regionName'))
                    ->where('elec_introduced_type', $request->get('elecIntroType'))
                    ->pluck('fee_import');

                $site_sha_dis = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_site'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_site');
                $import_sha_dis = DB::table('share_discount')
                    ->where('is_new_tower', '是')
                    ->where('share_type', $request->get('shareType_import'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', '否')
                    ->pluck('discount_import');

                $fee_tow_disd = $fee_tow1[0] * $tow_sha_dis1[0] +
                    ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * $tow_sha_dis_oth[0] * 0.3;
                $fee_hou_disd = $fee_hou1[0] * $hou_sha_dis1[0] +
                    ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * $hou_sha_dis_oth[0] * 0.3;
                $fee_sup_disd = $fee_sup1[0] * $sup_sha_dis1[0] +
                    ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * $sup_sha_dis_oth[0] * 0.3;
                $fee_main_disd = $fee_main1[0] * $main_sha_dis1[0] +
                    ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * $main_sha_dis_oth[0] * 0.3;
                $fee_site_disd = $fee_site[0] * $site_sha_dis[0];
                $fee_import_disd = $fee_import[0] * $import_sha_dis[0];
                $site_price = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_latest_record', '是')
                    ->get();
                if (empty($site_price)) {
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tow1' => $fee_tow1[0],
                            'fee_hou1' => $fee_hou1[0],
                            'fee_sup1' => $fee_sup1[0],
                            'fee_main1' => $fee_main1[0],
                            'fee_tow2' => $fee_tow2[0] * 0.3,
                            'fee_hou2' => $fee_hou2[0] * 0.3,
                            'fee_sup2' => $fee_sup2[0] * 0.3,
                            'fee_main2' => $fee_main2[0] * 0.3,
                            'fee_tow3' => $fee_tow3[0] * 0.3,
                            'fee_hou3' => $fee_hou3[0] * 0.3,
                            'fee_sup3' => $fee_sup3[0] * 0.3,
                            'fee_main3' => $fee_main3[0] * 0.3,
                            'fee_tow4' => $fee_tow4[0] * 0.3,
                            'fee_hou4' => $fee_hou4[0] * 0.3,
                            'fee_sup4' => $fee_sup4[0] * 0.3,
                            'fee_main4' => $fee_main4[0] * 0.3,
                            'fee_tow5' => $fee_tow5[0] * 0.3,
                            'fee_hou5' => $fee_hou5[0] * 0.3,
                            'fee_sup5' => $fee_sup5[0] * 0.3,
                            'fee_main5' => $fee_main5[0] * 0.3,
                            'fee_tow' => $fee_tow1[0] + ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * 0.3,
                            'fee_hou' => $fee_hou1[0] + ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * 0.3,
                            'fee_sup' => $fee_sup1[0] + ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * 0.3,
                            'fee_main' => $fee_main1[0] + ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * 0.3,
                            'tow_sha_dis1' => $tow_sha_dis1[0],
                            'hou_sha_dis1' => $hou_sha_dis1[0],
                            'sup_sha_dis1' => $sup_sha_dis1[0],
                            'main_sha_dis1' => $main_sha_dis1[0],
                            'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                            'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                            'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                            'main_sha_dis_oth' => $main_sha_dis_oth[0],
                            'fee_tow_disd' => $fee_tow_disd,
                            'fee_hou_disd' => $fee_hou_disd,
                            'fee_sup_disd' => $fee_sup_disd,
                            'fee_main_disd' => $fee_main_disd,
                            'fee_site' => $fee_site[0],
                            'site_sha_dis' => $site_sha_dis[0],
                            'fee_site_disd' => $fee_site_disd,
                            'fee_import' => $fee_import[0],
                            'import_sha_dis' => $import_sha_dis[0],
                            'fee_import_disd' => $fee_import_disd,
                            'is_latest_record' => '是',
                            'modify_time' => $request->get('modifyTime'),
                            'region_name' => $request->get('regionName')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, false, $insSitePrice);
                } else {
                    $updSitePrice = DB::table('fee_out_site_price')
                        ->where('site_code', $request->get('siteCode'))
                        ->where('is_latest_record', '是')
                        ->update([
                            'is_latest_record' => '否',
//                        'updated_at' => date('Y-m-d h:i:s',time())
                        ]);
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tow1' => $fee_tow1[0],
                            'fee_hou1' => $fee_hou1[0],
                            'fee_sup1' => $fee_sup1[0],
                            'fee_main1' => $fee_main1[0],
                            'fee_tow2' => $fee_tow2[0] * 0.3,
                            'fee_hou2' => $fee_hou2[0] * 0.3,
                            'fee_sup2' => $fee_sup2[0] * 0.3,
                            'fee_main2' => $fee_main2[0] * 0.3,
                            'fee_tow3' => $fee_tow3[0] * 0.3,
                            'fee_hou3' => $fee_hou3[0] * 0.3,
                            'fee_sup3' => $fee_sup3[0] * 0.3,
                            'fee_main3' => $fee_main3[0] * 0.3,
                            'fee_tow4' => $fee_tow4[0] * 0.3,
                            'fee_hou4' => $fee_hou4[0] * 0.3,
                            'fee_sup4' => $fee_sup4[0] * 0.3,
                            'fee_main4' => $fee_main4[0] * 0.3,
                            'fee_tow5' => $fee_tow5[0] * 0.3,
                            'fee_hou5' => $fee_hou5[0] * 0.3,
                            'fee_sup5' => $fee_sup5[0] * 0.3,
                            'fee_main5' => $fee_main5[0] * 0.3,
                            'fee_tow' => $fee_tow1[0] + ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * 0.3,
                            'fee_hou' => $fee_hou1[0] + ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * 0.3,
                            'fee_sup' => $fee_sup1[0] + ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * 0.3,
                            'fee_main' => $fee_main1[0] + ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * 0.3,
                            'tow_sha_dis1' => $tow_sha_dis1[0],
                            'hou_sha_dis1' => $hou_sha_dis1[0],
                            'sup_sha_dis1' => $sup_sha_dis1[0],
                            'main_sha_dis1' => $main_sha_dis1[0],
                            'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                            'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                            'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                            'main_sha_dis_oth' => $main_sha_dis_oth[0],
                            'fee_tow_disd' => $fee_tow_disd,
                            'fee_hou_disd' => $fee_hou_disd,
                            'fee_sup_disd' => $fee_sup_disd,
                            'fee_main_disd' => $fee_main_disd,
                            'fee_site' => $fee_site[0],
                            'site_sha_dis' => $site_sha_dis[0],
                            'fee_site_disd' => $fee_site_disd,
                            'fee_import' => $fee_import[0],
                            'import_sha_dis' => $import_sha_dis[0],
                            'fee_import_disd' => $fee_import_disd,
                            'is_latest_record' => '是',
                            'modify_time' => $request->get('modifyTime'),
                            'region_name' => $request->get('regionName')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, $updSitePrice, $insSitePrice);
                }

            }
            if ($request->get('isNewTower') == '否') {
                $insSiteInfo = DB::table('site_info')->insert(
                    ['site_code' => $request->get('siteCode'),
                        'region_name' => $request->get('regionName'),
                        'product_type' => $request->get('productType'),
                        'share_type_tow' => $request->get('shareType_tower'),
                        'share_type_hou' => $request->get('shareType_house'),
                        'share_type_sup' => $request->get('shareType_supporting'),
                        'share_type_main' => $request->get('shareType_maintainence'),
                        'share_type_site' => $request->get('shareType_site'),
                        'share_type_import' => $request->get('shareType_import'),
                        'is_new_tower' => '否',
                        'is_newly_added' => $request->get('isNewlyAdded'),
                        'is_rru_away' => null,
                        'sys_num' => $request->get('sysNum'),
                        'sys1_height' => $sysHeight1,
                        'sys2_height' => $sysHeight2,
                        'sys3_height' => $sysHeight3,
                        'sys4_height' => $sysHeight4,
                        'sys5_height' => $sysHeight5,
                        'is_co_opetition' => $request->get('isCoOpetition'),
                        'is_latest_record' => '是',
                        'site_district_type' => null,
                        'tower_type' => $request->get('towerType'),
                        'land_form' => $request->get('landForm'),
                        'user_type' => $request->get('userType'),
                        'elec_introduced_type' => null,
                        'established_time' => $establishedTime[0],
                        'modify_time' => $request->get('modifyTime'),

                    ]);
                if ($sysHeight1 != null) {
                    $fee_tow1 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight1)
                        ->where('is_new_tower', '否')
                        ->pluck('fee_tow');
                    $fee_hou1 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_hou');
                    $fee_sup1 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_sup');
                    $fee_main1 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_main');
                    $tow_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_tower'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                    $hou_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_house'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                    $sup_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_supporting'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                    $main_sha_dis1 = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_maintainence'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                } else {
                    $fee_tow1 = 0;
                    $fee_hou1 = 0;
                    $fee_sup1 = 0;
                    $fee_main1 = 0;
                    $tow_sha_dis1 = null;
                    $hou_sha_dis1 = null;
                    $sup_sha_dis1 = null;
                    $main_sha_dis1 = null;
                }
                if ($sysHeight2 != null) {
                    $fee_tow2 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight2)
                        ->where('is_new_tower', '否')
                        ->pluck('fee_tow');
                    $fee_hou2 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_hou');
                    $fee_sup2 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_sup');
                    $fee_main2 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_main');

                } else {
                    $fee_tow2 = 0;
                    $fee_hou2 = 0;
                    $fee_sup2 = 0;
                    $fee_main2 = 0;
                }
                if ($sysHeight3 != null) {
                    $fee_tow3 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight3)
                        ->where('is_new_tower', '否')
                        ->pluck('fee_tow');
                    $fee_hou3 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_hou');
                    $fee_sup3 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_sup');
                    $fee_main3 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_main');
                } else {
                    $fee_tow3 = 0;
                    $fee_hou3 = 0;
                    $fee_sup3 = 0;
                    $fee_main3 = 0;
                }
                if ($sysHeight4 != null) {
                    $fee_tow4 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight4)
                        ->where('is_new_tower', '否')
                        ->pluck('fee_tow');
                    $fee_hou4 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_hou');
                    $fee_sup4 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_sup');
                    $fee_main4 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_main');
                } else {
                    $fee_tow4 = 0;
                    $fee_hou4 = 0;
                    $fee_sup4 = 0;
                    $fee_main4 = 0;
                }
                if ($sysHeight5 != null) {
                    $fee_tow5 = DB::table('fee_tow_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('sys_height', $sysHeight5)
                        ->where('is_new_tower', '否')
                        ->pluck('fee_tow');
                    $fee_hou5 = DB::table('fee_hou_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_hou');
                    $fee_sup5 = DB::table('fee_sup_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_sup');
                    $fee_main5 = DB::table('fee_main_table')
                        ->where('tower_type', $request->get('towerType'))
                        ->where('product_type', $request->get('productType'))
                        ->where('is_new_tower', '否')
                        ->pluck('fee_main');
                } else {
                    $fee_tow5 = 0;
                    $fee_hou5 = 0;
                    $fee_sup5 = 0;
                    $fee_main5 = 0;
                }
                if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                    $tow_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_tower'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                    $hou_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_house'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                    $sup_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_supporting'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                    $main_sha_dis_oth = DB::table('share_discount')
                        ->where('is_new_tower', '否')
                        ->where('share_type', $request->get('shareType_maintainence'))
                        ->where('user_type', $request->get('userType'))
                        ->where('is_newly_added', $request->get('isNewlyAdded'))
                        ->pluck('discount_basic');
                } else {
                    $tow_sha_dis_oth = null;
                    $hou_sha_dis_oth = null;
                    $sup_sha_dis_oth = null;
                    $main_sha_dis_oth = null;
                }

                $fee_site = $request->get('feeSiteOld');
                $fee_import = 0;

                $site_sha_dis = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_site'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', $request->get('isNewlyAdded'))
                    ->pluck('discount_site');
                $import_sha_dis = DB::table('share_discount')
                    ->where('is_new_tower', '否')
                    ->where('share_type', $request->get('shareType_import'))
                    ->where('user_type', $request->get('userType'))
                    ->where('is_newly_added', $request->get('isNewlyAdded'))
                    ->pluck('discount_import');
                $fee_tow_disd = $fee_tow1[0] * $tow_sha_dis1[0] +
                    ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * $tow_sha_dis_oth[0] * 0.3;
                $fee_hou_disd = $fee_hou1[0] * $hou_sha_dis1[0] +
                    ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * $hou_sha_dis_oth[0] * 0.3;
                $fee_sup_disd = $fee_sup1[0] * $sup_sha_dis1[0] +
                    ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * $sup_sha_dis_oth[0] * 0.3;
                $fee_main_disd = $fee_main1[0] * $main_sha_dis1[0] +
                    ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * $main_sha_dis_oth[0] * 0.3;
                $fee_site_disd = $fee_site * $site_sha_dis[0];
                $fee_import_disd = $fee_import * $import_sha_dis[0];
                $site_price = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_latest_record', '是')
                    ->get();
                if (empty($site_price)) {
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tow1' => $fee_tow1[0],
                            'fee_hou1' => $fee_hou1[0],
                            'fee_sup1' => $fee_sup1[0],
                            'fee_main1' => $fee_main1[0],
                            'fee_tow2' => $fee_tow2[0] * 0.3,
                            'fee_hou2' => $fee_hou2[0] * 0.3,
                            'fee_sup2' => $fee_sup2[0] * 0.3,
                            'fee_main2' => $fee_main2[0] * 0.3,
                            'fee_tow3' => $fee_tow3[0] * 0.3,
                            'fee_hou3' => $fee_hou3[0] * 0.3,
                            'fee_sup3' => $fee_sup3[0] * 0.3,
                            'fee_main3' => $fee_main3[0] * 0.3,
                            'fee_tow4' => $fee_tow4[0] * 0.3,
                            'fee_hou4' => $fee_hou4[0] * 0.3,
                            'fee_sup4' => $fee_sup4[0] * 0.3,
                            'fee_main4' => $fee_main4[0] * 0.3,
                            'fee_tow5' => $fee_tow5[0] * 0.3,
                            'fee_hou5' => $fee_hou5[0] * 0.3,
                            'fee_sup5' => $fee_sup5[0] * 0.3,
                            'fee_main5' => $fee_main5[0] * 0.3,
                            'fee_tow' => $fee_tow1[0] + ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * 0.3,
                            'fee_hou' => $fee_hou1[0] + ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * 0.3,
                            'fee_sup' => $fee_sup1[0] + ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * 0.3,
                            'fee_main' => $fee_main1[0] + ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * 0.3,
                            'tow_sha_dis1' => $tow_sha_dis1[0],
                            'hou_sha_dis1' => $hou_sha_dis1[0],
                            'sup_sha_dis1' => $sup_sha_dis1[0],
                            'main_sha_dis1' => $main_sha_dis1[0],
                            'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                            'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                            'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                            'main_sha_dis_oth' => $main_sha_dis_oth[0],
                            'fee_tow_disd' => $fee_tow_disd,
                            'fee_hou_disd' => $fee_hou_disd,
                            'fee_sup_disd' => $fee_sup_disd,
                            'fee_main_disd' => $fee_main_disd,
                            'fee_site' => $fee_site,
                            'site_sha_dis' => $site_sha_dis[0],
                            'fee_site_disd' => $fee_site_disd,
                            'fee_import' => $fee_import,
                            'import_sha_dis' => $import_sha_dis[0],
                            'fee_import_disd' => $fee_import_disd,
                            'is_latest_record' => '是',
                            'modify_time' => $request->get('modifyTime'),
                            'region_name' => $request->get('regionName')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, false, $insSitePrice);
                } else {
                    $updSitePrice = DB::table('fee_out_site_price')
                        ->where('site_code', $request->get('siteCode'))
                        ->where('is_latest_record', '是')
                        ->update([
                            'is_latest_record' => '否',
//                        'updated_at' => date('Y-m-d h:i:s',time())
                        ]);
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tow1' => $fee_tow1[0],
                            'fee_hou1' => $fee_hou1[0],
                            'fee_sup1' => $fee_sup1[0],
                            'fee_main1' => $fee_main1[0],
                            'fee_tow2' => $fee_tow2[0] * 0.3,
                            'fee_hou2' => $fee_hou2[0] * 0.3,
                            'fee_sup2' => $fee_sup2[0] * 0.3,
                            'fee_main2' => $fee_main2[0] * 0.3,
                            'fee_tow3' => $fee_tow3[0] * 0.3,
                            'fee_hou3' => $fee_hou3[0] * 0.3,
                            'fee_sup3' => $fee_sup3[0] * 0.3,
                            'fee_main3' => $fee_main3[0] * 0.3,
                            'fee_tow4' => $fee_tow4[0] * 0.3,
                            'fee_hou4' => $fee_hou4[0] * 0.3,
                            'fee_sup4' => $fee_sup4[0] * 0.3,
                            'fee_main4' => $fee_main4[0] * 0.3,
                            'fee_tow5' => $fee_tow5[0] * 0.3,
                            'fee_hou5' => $fee_hou5[0] * 0.3,
                            'fee_sup5' => $fee_sup5[0] * 0.3,
                            'fee_main5' => $fee_main5[0] * 0.3,
                            'fee_tow' => $fee_tow1[0] + ($fee_tow2[0] + $fee_tow3[0] + $fee_tow4[0] + $fee_tow5[0]) * 0.3,
                            'fee_hou' => $fee_hou1[0] + ($fee_hou2[0] + $fee_hou3[0] + $fee_hou4[0] + $fee_hou5[0]) * 0.3,
                            'fee_sup' => $fee_sup1[0] + ($fee_sup2[0] + $fee_sup3[0] + $fee_sup4[0] + $fee_sup5[0]) * 0.3,
                            'fee_main' => $fee_main1[0] + ($fee_main2[0] + $fee_main3[0] + $fee_main4[0] + $fee_main5[0]) * 0.3,
                            'tow_sha_dis1' => $tow_sha_dis1[0],
                            'hou_sha_dis1' => $hou_sha_dis1[0],
                            'sup_sha_dis1' => $sup_sha_dis1[0],
                            'main_sha_dis1' => $main_sha_dis1[0],
                            'tow_sha_dis_oth' => $tow_sha_dis_oth[0],
                            'hou_sha_dis_oth' => $hou_sha_dis_oth[0],
                            'sup_sha_dis_oth' => $sup_sha_dis_oth[0],
                            'main_sha_dis_oth' => $main_sha_dis_oth[0],
                            'fee_tow_disd' => $fee_tow_disd,
                            'fee_hou_disd' => $fee_hou_disd,
                            'fee_sup_disd' => $fee_sup_disd,
                            'fee_main_disd' => $fee_main_disd,
                            'fee_site' => $fee_site,
                            'site_sha_dis' => $site_sha_dis[0],
                            'fee_site_disd' => $fee_site_disd,
                            'fee_import' => $fee_import,
                            'import_sha_dis' => $import_sha_dis[0],
                            'fee_import_disd' => $fee_import_disd,
                            'is_latest_record' => '是',
                            'modify_time' => $request->get('modifyTime'),
                            'region_name' => $request->get('regionName')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, $updSitePrice, $insSitePrice);
                }
            }
        }else{
            echo "<script language=javascript>alert('系统高度和铁塔类型不匹配！');history.back();</script>";
        }


    }

}

