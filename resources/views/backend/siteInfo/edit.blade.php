@extends('layouts.app')

@section('header')
    <title>编辑站址信息</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">站址信息维护</a>
        <td>>>></td>
        <a href="#">站址信息编辑</a>
    </div>

    <body class="input managerInfo" onload="doLoad({{$siteInfo->sys_num}})">
    <div class="bar">
        <div style="float:left;">
            请修改或者删除站址信息
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteInfo/update')}}" style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$siteInfo->id}}"/>
        <input name="region" type="hidden" value="{{$region}}">
        <input type="hidden" name="isNewTower" value="{{$siteInfo->is_new_tower}}">
        <input type="hidden" name="siteCode" value="{{$siteInfo->site_code}}">
        <input type="hidden" name="regionName" value="{{$siteInfo->region_name}}">
        <table class="inputTable tabContent">
            <tr>
                <th>
                    站址编码 :
                </th>
                <td>

                    <input type="text" @if(isset($siteInfo->site_code)) value="{{$siteInfo->site_code}}"
                           @endif id="siteCode" disabled="disabled">
                </td>
            </tr>
            <tr>
                <th>
                    地市 :
                </th>
                <td>

                    <input type="text"
                           @if(isset($siteInfo->region_name)) value="{{$siteInfo->region_name}}" @endif id="region"
                           disabled="disabled">
                </td>
            </tr>
            <tr>
                <th>
                    是否为新建站 :
                </th>

                <td>
                    <input type="radio" id="isNewTower" value="是"
                           @if(isset($siteInfo->is_new_tower) && $siteInfo->is_new_tower == '是') checked="checked"@endif disabled>是
                    <input type="radio" id="isNewTower" value="否"
                           @if(isset($siteInfo->is_new_tower) && $siteInfo->is_new_tower == '否') checked="checked"@endif disabled>否

                </td>
            </tr>
            <tr>
                <th>站址属性变更日期</th>
                <td>
                    <input type="text" id="modifyTime" name="modifyTime" style="width:65px;padding-left:5px"
                           readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
                </td>
            </tr>
            <tr>
                <th>
                    是否为竞合站点 :
                </th>

                <td>
                    <input type="radio" name="isCoOpetition" id="isCoOpetition" value="是"
                           @if(isset($siteInfo->is_co_opetition) && $siteInfo->is_co_opetition == '是') checked="checked" @endif>是
                    <input type="radio" name="isCoOpetition" id="isCoOpetition" value="否"
                           @if(isset($siteInfo->is_co_opetition) && $siteInfo->is_co_opetition == '否') checked="checked" @endif>否

                </td>
            </tr>
            @if($siteInfo->is_new_tower == '是')
            <tr>
                <th>
                    站址所在地区类型:
                </th>
                <td>
                    <input type="radio" name="siteDistType" id="siteDistType" value="市区"
                           @if(isset($siteInfo->site_district_type) && $siteInfo->site_district_type=="市区") checked="checked"@endif>市区
                    <input type="radio" name="siteDistType" id="siteDistType" value="城镇"
                           @if(isset($siteInfo->site_district_type) && $siteInfo->site_district_type=="城镇") checked="checked"@endif>城镇
                    <input type="radio" name="siteDistType" id="siteDistType" value="农村"
                           @if(isset($siteInfo->site_district_type) && $siteInfo->site_district_type=="农村") checked="checked"@endif>农村


                </td>
            </tr>
            <tr>
                <th>
                    是否RRU拉远:
                </th>
                <td>
                    <input type="radio" name="rruAway" id="rruAway" value="是"
                           @if(isset($siteInfo->is_rru_away) && $siteInfo->is_rru_away=="是") checked="checked"@endif>是
                    <input type="radio" name="rruAway" id="rruAway" value="否"
                           @if(isset($siteInfo->is_rru_away) && $siteInfo->is_rru_away=="否")checked="checked"@endif>否


                </td>
            </tr>
                <tr>
                    <th>
                        引电类型(V):
                    </th>
                    <td>
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="380V"
                               @if(isset($siteInfo->elec_introduced_type) && $siteInfo->elec_introduced_type=="380V") checked="checked" @endif>380V
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="220V"
                               @if(isset($siteInfo->elec_introduced_type) && $siteInfo->elec_introduced_type=="220V") checked="checked" @endif>220V
                    </td>
                </tr>
            @endif
            <tr>
                <th>
                    产品配套类型 :
                </th>

                <td>
                    <input type="radio" name="productType" id="productType" value="铁塔+自有机房+配套"
                           @if(isset($siteInfo->product_type) && $siteInfo->product_type == '铁塔+自有机房+配套') checked="checked"@endif>铁塔+自有机房+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+租赁机房+配套"
                           @if(isset($siteInfo->product_type) && $siteInfo->product_type == '铁塔+租赁机房+配套')checked="checked"@endif>铁塔+租赁机房+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+一体化机柜+配套"
                           @if(isset($siteInfo->product_type) && $siteInfo->product_type == '铁塔+一体化机柜+配套') checked="checked"@endif>铁塔+一体化机柜+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+RRU拉远+配套"
                           @if(isset($siteInfo->product_type) && $siteInfo->product_type == '铁塔+RRU拉远+配套') checked="checked"@endif>铁塔+RRU拉远+配套
                    <input type="radio" name="productType" id="productType" value="铁塔(无机房及配套)"
                           @if(isset($siteInfo->product_type) && $siteInfo->product_type == '铁塔(无机房+无配套)') checked="checked"@endif>铁塔(无机房及配套)

                </td>
            </tr>
            <tr>
                <th>
                    铁塔类型:
                </th>
                <td>
                    <input type="radio" name="towerType" id="towerType" value="普通地面塔"
                           @if(isset($siteInfo->tower_type) && $siteInfo->tower_type=="普通地面塔") checked="checked" @endif
                           onclick="towerTypeChange(this)">普通地面塔
                    <input type="radio" name="towerType" id="towerType" value="景观塔"
                           @if(isset($siteInfo->tower_type) && $siteInfo->tower_type=="景观塔") checked="checked" @endif
                           onclick="towerTypeChange(this)">景观塔
                    <input type="radio" name="towerType" id="towerType" value="简易塔"
                           @if(isset($siteInfo->tower_type) && $siteInfo->tower_type=="简易塔") checked="checked" @endif
                           onclick="towerTypeChange(this)">简易塔
                    <input type="radio" name="towerType" id="towerType" value="普通楼面塔"
                           @if(isset($siteInfo->tower_type) && $siteInfo->tower_type=="普通楼面塔") checked="checked" @endif
                           onclick="towerTypeChange(this)">普通楼面塔
                    <input type="radio" name="towerType" id="towerType" value="楼面抱杆"
                           @if(isset($siteInfo->tower_type) && $siteInfo->tower_type=="楼面抱杆") checked="checked" @endif
                           onclick="towerTypeChange(this)">楼面抱杆


                </td>
            </tr>
            <tr>
                <th>系统数量</th>
                <td>
                    <input type="radio" name="sysNum" id="sysNum" value="1"
                           @if(isset($siteInfo->sys_num) && $siteInfo->sys_num=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum" id="sysNum" value="2"
                           @if(isset($siteInfo->sys_num) && $siteInfo->sys_num=="2") checked="checked"@endif>2
                    <input type="radio" name="sysNum" id="sysNum" value="3"
                           @if(isset($siteInfo->sys_num) && $siteInfo->sys_num=="3") checked="checked"@endif>3
                    <input type="radio" name="sysNum" id="sysNum" value="4"
                           @if(isset($siteInfo->sys_num) && $siteInfo->sys_num=="4") checked="checked"@endif>4
                    <input type="radio" name="sysNum" id="sysNum" value="5"
                           @if(isset($siteInfo->sys_num) && $siteInfo->sys_num=="5") checked="checked"@endif>5

                </td>
            </tr>
            <tr>
                <th>
                    系统1挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight1" value="无"
                           @if($siteInfo->sys1_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight1" value="H<20"
                           @if($siteInfo->sys1_height == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight1" id="h2" value="20<=H<25"
                           @if($siteInfo->sys1_height == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight1" value="25<=H<30"
                           @if($siteInfo->sys1_height == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight1" value="H<30"
                           @if($siteInfo->sys1_height == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight1" value="30<=H<35"
                           @if($siteInfo->sys1_height == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight1" value="35<=H<40"
                           @if($siteInfo->sys1_height == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight1" value="40<=H<45"
                           @if($siteInfo->sys1_height == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight1" value="45<=H<50"
                           @if($siteInfo->sys1_height == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight1" value="任意高度"
                           @if($siteInfo->sys1_height == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>
                    系统2挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight2" value="无"
                           @if($siteInfo->sys2_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight2" value="H<20"
                           @if($siteInfo->sys2_height == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight2" id="h2" value="20<=H<25"
                           @if($siteInfo->sys2_height == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight2" value="25<=H<30"
                           @if($siteInfo->sys2_height == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight2" value="H<30"
                           @if($siteInfo->sys2_height == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight2" value="30<=H<35"
                           @if($siteInfo->sys2_height == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight2" value="35<=H<40"
                           @if($siteInfo->sys2_height == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight2" value="40<=H<45"
                           @if($siteInfo->sys2_height == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight2" value="45<=H<50"
                           @if($siteInfo->sys2_height == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight2" value="任意高度"
                           @if($siteInfo->sys2_height == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>
                    系统3挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight3" value="无"
                           @if($siteInfo->sys3_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight3" value="H<20"
                           @if($siteInfo->sys3_height == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight3" id="h2" value="20<=H<25"
                           @if($siteInfo->sys3_height == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight3" value="25<=H<30"
                           @if($siteInfo->sys3_height == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight3" value="H<30"
                           @if($siteInfo->sys3_height == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight3" value="30<=H<35"
                           @if($siteInfo->sys3_height == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight3" value="35<=H<40"
                           @if($siteInfo->sys3_height == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight3" value="40<=H<45"
                           @if($siteInfo->sys3_height == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight3" value="45<=H<50"
                           @if($siteInfo->sys3_height == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight3" value="任意高度"
                           @if($siteInfo->sys3_height == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr id="sys4">
                <th>
                    系统4挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight4" value="无"
                           @if($siteInfo->sys4_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight4" value="H<20"
                           @if($siteInfo->sys4_height == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight4" id="h2" value="20<=H<25"
                           @if($siteInfo->sys4_height == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight4" value="25<=H<30"
                           @if($siteInfo->sys4_height == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight4" value="H<30"
                           @if($siteInfo->sys4_height == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight4" value="30<=H<35"
                           @if($siteInfo->sys4_height == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight4" value="35<=H<40"
                           @if($siteInfo->sys4_height == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight4" value="40<=H<45"
                           @if($siteInfo->sys4_height == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight4" value="45<=H<50"
                           @if($siteInfo->sys4_height == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight4" value="任意高度"
                           @if($siteInfo->sys4_height == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr id="sys5">
                <th>
                    系统5挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight5" value="无"
                           @if($siteInfo->sys5_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight5" value="H<20"
                           @if($siteInfo->sys5_height == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight5" id="h2" value="20<=H<25"
                           @if($siteInfo->sys5_height == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight5" value="25<=H<30"
                           @if($siteInfo->sys5_height == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight5" value="H<30"
                           @if($siteInfo->sys5_height == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight5" value="30<=H<35"
                           @if($siteInfo->sys5_height == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight5" value="35<=H<40"
                           @if($siteInfo->sys5_height == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight5" value="40<=H<45"
                           @if($siteInfo->sys5_height == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight5" value="45<=H<50"
                           @if($siteInfo->sys5_height == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight5" value="任意高度"
                           @if($siteInfo->sys5_height == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>
                    覆盖场景:
                </th>
                <td>
                    <input type="radio" name="landForm" id="landForm" value="山区"
                           @if(isset($siteInfo->land_form) && $siteInfo->land_form=="山区") checked="checked"@endif>山区
                    <input type="radio" name="landForm" id="landForm" value="平原"
                           @if(isset($siteInfo->land_form) && $siteInfo->land_form=="平原") checked="checked"@endif>平原



                </td>
            </tr>
            <tr>
                <th>
                    用户类型:
                </th>
                <td>
                    @if($siteInfo->is_new_tower == '是')<div id="userType1" style="float: left;"><input type="radio" name="userType" id="userType_old"
                                               value="锚定用户"
                                               @if($siteInfo->user_type=="锚定用户") checked="checked" @endif>锚定用户
                    </div>@endif
                    @if($siteInfo->is_new_tower == '否')<div id="userType2" style="float: left;"><input type="radio" name="userType" value="原产权"
                                               @if($siteInfo->user_type=="原产权") checked="checked"@endif>原产权
                    </div>@endif
                    @if($siteInfo->is_new_tower == '是')<div id="userType3" style="float: left;"><input type="radio" name="userType" id="userType_otheruser"
                                               value="其他用户"
                                               @if($siteInfo->user_type=="其他用户") checked="checked"@endif>其他用户
                    </div>@endif
                    @if($siteInfo->is_new_tower == '否')<div id="userType4" style="float: left;"><input type="radio" name="userType" value="既有共享"
                                               @if($siteInfo->user_type=="既有共享") checked="checked"@endif>既有共享
                    </div>@endif
                    @if($siteInfo->is_new_tower == '否')<div id="userType5" style="float: left;"><input type="radio" name="userType" value="新增共享"
                                               @if($siteInfo->user_type=="新增共享") checked="checked"@endif>新增共享
                    </div>@endif



                </td>
            </tr>
            <tr>
                <th>
                    铁塔共享类型:
                </th>
                <td>

                    <input type="radio" name="shareType_tower" id="shareType_tower" value="电信独享"
                           @if(isset($siteInfo->share_type_tow) && $siteInfo->share_type_tow=="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareType_tower" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_type_tow) && $siteInfo->share_type_tow=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareType_tower" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_type_tow) && $siteInfo->share_type_tow=="三家共享") checked="checked"
                           @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    机房共享类型:
                </th>
                <td>

                    <input type="radio" name="shareType_house" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_type_hou) && $siteInfo->share_type_hou=="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareType_house" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_type_hou) && $siteInfo->share_type_hou=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareType_house" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_type_hou) && $siteInfo->share_type_hou=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    配套共享类型:
                </th>
                <td>

                    <input type="radio" name="shareType_supporting" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_type_sup) && $siteInfo->share_type_sup=="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareType_supporting" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_type_sup) && $siteInfo->share_type_sup=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareType_supporting" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_type_sup) && $siteInfo->share_type_sup=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    维护共享类型:
                </th>
                <td>

                    <input type="radio" name="shareType_maintainence" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_type_main) && $siteInfo->share_type_main=="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareType_maintainence" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_type_main) && $siteInfo->share_type_main=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareType_maintainence" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_type_main) && $siteInfo->share_type_main=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    场地费共享类型:
                </th>
                <td>

                    <input type="radio" name="shareType_site" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_type_site) && $siteInfo->share_type_site=="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareType_site" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_type_site) && $siteInfo->share_type_site=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareType_site" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_type_site) && $siteInfo->share_type_site=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    电力引入费共享类型:
                </th>
                <td>

                    <input type="radio" name="shareType_import" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_type_import) && $siteInfo->share_type_import=="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareType_import" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_type_import) && $siteInfo->share_type_import=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareType_import" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_type_import) && $siteInfo->share_type_import=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>








                @if($siteInfo->is_new_tower == '否')<tr>
                <th>
                    是否存在新增共享:
                </th>
                <td>
                    <input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="是" @if($siteInfo->is_newly_added == '是') checked="checked" @endif>是
                    <input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="否" @if($siteInfo->is_newly_added == '否') checked="checked" @endif>否

                </td>
            </tr>
                    <tr>
                        <th>场地费</th>
                        <td>
                            <input type="text" name="feeSiteOld" id="feeSiteOld" value="{{$feeSiteOld}}">
                        </td>
                    </tr>
            @endif


        </table>
        <input class="formButton" type="button" value="修改" onclick="doModify()">
    </form>
    <form action="{{url('backend/siteInfo/delete/'.$siteInfo->site_code)}}" method="get" style="display:inline;"
          id="delForm">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="hidden" value="{{$region}}" name="region">
        <input type="button" class="formButton" value="删除" onclick="doDel()">
    </form>
    <input type="button" class="formButton" value="返回" onclick="doBack()">
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_site').addClass("current");
        });

        function doBack() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/siteInfo/back')}}";
            listForm.submit();
        }

        function doModify() {
            var siteCode = $('#siteCode').val();
            var modifyTime = $('#modifyTime').val();
            var towerType = document.getElementById('towerType');
            var sysNum = document.getElementsByName('sysNum');
            var sysHeight1 = document.getElementsByName('sysHeight1');
            var sysHeight2 = document.getElementsByName('sysHeight2');
            var sysHeight3 = document.getElementsByName('sysHeight3');
            var sysHeight4 = document.getElementsByName('sysHeight4');
            var sysHeight5 = document.getElementsByName('sysHeight5');
            for (var i = 0; i < sysNum.length; i++){
                if(sysNum[i].checked){
                    var sys_Num = sysNum[i].value;
                }
            }
            for (var i = 0; i < sysHeight1.length; i++){
                if(sysHeight1[i].checked){
                    var sysHeight_1 = sysHeight1[i].value;
                }
            }
            for (var i = 0; i < sysHeight2.length; i++){
                if(sysHeight2[i].checked){
                    var sysHeight_2 = sysHeight2[i].value;
                }
            }
            for (var i = 0; i < sysHeight3.length; i++){
                if(sysHeight3[i].checked){
                    var sysHeight_3 = sysHeight3[i].value;
                }
            }
            for (var i = 0; i < sysHeight4.length; i++){
                if(sysHeight4[i].checked){
                    var sysHeight_4 = sysHeight4[i].value;
                }
            }
            for (var i = 0; i < sysHeight5.length; i++){
                if(sysHeight5[i].checked){
                    var sysHeight_5 = sysHeight5[i].value;
                }
            }


            if(modifyTime == ''){
                alert('请输入属性变更日期！');
                return;
            }
            if(sys_Num == '1'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }

//                if (towerType == '普通地面塔'){
//                    if(sysHeight_1 != 'H<30' && sysHeight_1 != '30<=H<35' && sysHeight_1 != '35<=H<40' &&
//                        sysHeight_1 != '40<=H<45' && sysHeight_1 != '45<=H<50'){
//                        alert('系统1的高度与铁塔类型不匹配！');
//                        return;
//                    }
//                }
//                if (towerType == '景观塔'){
//                    alert(sysHeight_1);
//                    if(sysHeight_1 != 'H<20' && sysHeight_1 != '20<=H<25' && sysHeight_1 != '25<=H<30' &&
//                        sysHeight_1 != '30<=H<35' && sysHeight_1 != '35<=H<40'){
//                        alert('系统1的高度与铁塔类型不匹配！');
//                        return;
//                    }
//                }
//                if (towerType == '简易塔' || towerType == '普通楼面塔' || towerType == '楼面抱杆'){
//                    if(sysHeight_1 != '任意高度'){
//                        alert('系统1的高度与铁塔类型不匹配！');
//                        return;
//                    }
//                }
            }
            if(sys_Num == '2'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
            }
            if(sys_Num == '3'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无'){
                    alert('请选择系统3的挂高！');
                    return;
                }
            }
            if(sys_Num == '4'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无'){
                    alert('请选择系统3的挂高！');
                    return;
                }
                if (sysHeight_4 == '无'){
                    alert('请选择系统4的挂高！');
                    return;
                }
            }
            if(sys_Num == '5'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无'){
                    alert('请选择系统3的挂高！');
                    return;
                }
                if (sysHeight_4 == '无'){
                    alert('请选择系统4的挂高！');
                    return;
                }
                if (sysHeight_5 == '无'){
                    alert('请选择系统5的挂高！');
                    return;
                }
            }
            if (siteCode == '') {
                alert('请输入站址编码！');
                return;
            }
            if (confirm('确认提交吗？')) {
                var form = $('#listForm');
                form.submit();
            }


        }

        function doDel() {
            if (confirm('确认删除吗？')) {
                var delForm = $('#delForm');
                delForm.submit();
            }

        }

        function towerTypeChange(osel) {
            var h1 = document.getElementsByName('h1');
            var h2 = document.getElementsByName('h2');
            var h3 = document.getElementsByName('h3');
            var h4 = document.getElementsByName('h4');
            var h5 = document.getElementsByName('h5');
            var h6 = document.getElementsByName('h6');
            var h7 = document.getElementsByName('h7');
            var h8 = document.getElementsByName('h8');
            var h9 = document.getElementsByName('h9');
            if (osel.value == '普通地面塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'inline';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'inline';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'inline';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'inline';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'inline';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'none';
                }
            }
            if (osel.value == '景观塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'inline';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'inline';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'inline';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'inline';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'inline';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'none';
                }
            }
            if (osel.value == '简易塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'none';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'none';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'inline';
                }
            }
            if (osel.value == '普通楼面塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'none';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'none';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'inline';
                }
            }
            if (osel.value == '楼面抱杆') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'none';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'none';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'inline';
                }
            }


        }

        function shareTypeChange(osel) {
            var userType1 = document.getElementById('userType1');
            var userType2 = document.getElementById('userType2');
            if (osel.options[osel.selectedIndex].text == '电信独享') {
                userType1.style.display = 'inline';
                userType2.style.display = 'none';
            }
            else {
                userType1.style.display = 'none';
                userType2.style.display = 'inline';
            }
        }

        function sysNumChange(osel) {
            var sys1 = document.getElementById('sys1');
            var sys2 = document.getElementById('sys2');
            var sys3 = document.getElementById('sys3');
            var sys4 = document.getElementById('sys4');
            var sys5 = document.getElementById('sys5');
            if (osel.options[osel.selectedIndex].text == '1') {
                sys1.style.display = '';
                sys2.style.display = 'none';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '2') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '3') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '4') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '5') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = '';
            }

        }

        function doLoad(sysNum) {
            var sys1 = document.getElementById('sys1');
            var sys2 = document.getElementById('sys2');
            var sys3 = document.getElementById('sys3');
            var sys4 = document.getElementById('sys4');
            var sys5 = document.getElementById('sys5');
            if (sysNum == '1') {
                sys1.style.display = '';
                sys2.style.display = 'none';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (sysNum == '2') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (sysNum == '3') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (sysNum == '4') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = 'none';
            }
            if (sysNum == '5') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = '';
            }
        }


    </script>
@endsection







