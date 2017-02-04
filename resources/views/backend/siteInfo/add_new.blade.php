@extends('layouts.app')

@section('header')
    <title>站址信息新增</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">站址信息维护</a>
        <td>>>></td>
        <a href="#">新增站址</a>
    </div>

    <form id="listForm" method="post" action="{{url('backend/siteInfo/addNew')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input name="region" type="hidden" value="{{$region}}">
        <input name="url" type="hidden" value="{{$_SERVER['HTTP_REFERER']}}">
        <div class="input managerInfo">
            <div class="bar">
                批量新增
            </div>
            <table class="inputTable tabContent">
                <tr>

                    <td>
                        <input type="file" name="siteInfoFile" style="width: 170px" id="siteInfoFile">
                        <input type="button" class="formButton" value="导入" onclick="doImport()"/>
                    </td>
                </tr>
            </table>
        </div>

        <div class="input managerInfo">
            <div class="bar">
                批量修改
            </div>
            <table class="inputTable tabContent">
                <tr>

                    <td>
                        <input type="file" name="siteInfoToUpdateFile" style="width: 170px" id="siteInfoToUpdateFile">
                        <input type="button" class="formButton" value="导入" onclick="doBulkUpdate()"/>
                    </td>
                </tr>
            </table>
        </div>


        <div class="input managerInfo" style="margin-top: 25px;">
            <div class="bar">
                <div style="float:left;">
                    人工填写&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{url('backend/siteInfo/addNewPage'.'/'.$region)}}" style="color: #FF5809">新建站</a>
                    <a href="{{url('backend/siteInfo/addOldPage'.'/'.$region)}}">存量站</a>
                </div>


            </div>
            <div id="validateErrorContainer" class="validateErrorContainer">

            </div>

            <table class="inputTable tabContent">
                <tr>
                    <th>
                        站址编码 :
                    </th>
                    <td>

                        <input type="text" name="siteCode" id="siteCode">
                    </td>
                </tr>
                <tr>
                    <th>服务起始日期</th>
                    <td>
                        <input type="text" id="establishedTime" name="establishedTime" style="width:65px;padding-left:5px"
                               readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        地市 :
                    </th>
                    <td>
                        @if(Auth::user()->area_level != '湖北省' && Auth::user()->area_level != 'admin')
                            <select name="regionName" id="region">
                                @if(Auth::user()->area_level == '武汉'))
                                <option>武汉</option>@endif
                                @if(Auth::user()->area_level == '黄石'))
                                <option>黄石</option>@endif
                                @if(Auth::user()->area_level == '十堰'))
                                <option>十堰</option>@endif
                                @if(Auth::user()->area_level == '宜昌'))
                                <option>宜昌</option>@endif
                                @if(Auth::user()->area_level == '襄阳'))
                                <option>襄阳</option>@endif
                                @if(Auth::user()->area_level == '鄂州'))
                                <option>鄂州</option>@endif
                                @if(Auth::user()->area_level == '荆门'))
                                <option>荆门</option>@endif
                                @if(Auth::user()->area_level == '孝感'))
                                <option>孝感</option>@endif
                                @if(Auth::user()->area_level == '荆州'))
                                <option>荆州</option>@endif
                                @if(Auth::user()->area_level == '黄冈'))
                                <option>黄冈</option>@endif
                                @if(Auth::user()->area_level == '咸宁'))
                                <option>咸宁</option>@endif
                                @if(Auth::user()->area_level == '随州'))
                                <option>随州</option>@endif
                                @if(Auth::user()->area_level == '恩施'))
                                <option>恩施</option>@endif
                                @if(Auth::user()->area_level == '仙桃'))
                                <option>仙桃</option>@endif
                                @if(Auth::user()->area_level == '潜江'))
                                <option>潜江</option>@endif
                                @if(Auth::user()->area_level == '天门'))
                                <option>天门</option>@endif
                                @if(Auth::user()->area_level == '林区'))
                                <option>林区</option>@endif
                            </select>
                        @endif
                        @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                            <select name="regionName" id="region">
                                <option>武汉</option>
                                <option>黄石</option>
                                <option>十堰</option>
                                <option>宜昌</option>
                                <option>襄阳</option>
                                <option>鄂州</option>
                                <option>荆门</option>
                                <option>孝感</option>
                                <option>荆州</option>
                                <option>黄冈</option>
                                <option>咸宁</option>
                                <option>随州</option>
                                <option>恩施</option>
                                <option>仙桃</option>
                                <option>潜江</option>
                                <option>天门</option>
                                <option>林区</option>
                            </select>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        是否为竞合站点:
                    </th>
                    <td>
                        <input type="radio" name="isCoOpetition" id="isCoOpetition" value="是" checked="checked">是
                        <input type="radio" name="isCoOpetition" id="isCoOpetition" value="否">否
                        {{--<select name="isCoOpetition" id="isCoOpetition">--}}
                        {{--<option selected="selected">请选择...</option>--}}
                        {{--<option>是</option>--}}
                        {{--<option>否</option>--}}
                        {{--</select>--}}
                    </td>
                </tr>
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--是否为新建站:--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="radio" name="isNewTower" id="isNewTower" value="是" checked="checked">是--}}
                        {{--<input type="radio" name="isNewTower" id="isNewTower" value="否">否--}}
                        {{--<select name="isNewTower" id="isNewTower">--}}
                        {{--<option selected="selected">请选择...</option>--}}
                        {{--<option>是</option>--}}
                        {{--<option>否</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                <tr>
                    <th>
                        站址所在地区类型:
                    </th>
                    <td>
                        <input type="radio" name="siteDistType" id="siteDistType" value="市区" checked="checked">市区
                        <input type="radio" name="siteDistType" id="siteDistType" value="城镇">城镇
                        <input type="radio" name="siteDistType" id="siteDistType" value="农村">农村
                        {{--<select name="siteDistType" id="siteDistType">--}}
                        {{--<option selected="selected">请选择...</option>--}}
                        {{--<option>市区</option>--}}
                        {{--<option>城镇</option>--}}
                        {{--<option>农村</option>--}}
                        {{--</select>--}}
                    </td>
                </tr>
                <tr>
                    <th>
                        是否RRU拉远:
                    </th>
                    <td>
                        <input type="radio" name="rruAway" id="rruAway" value="是" checked="checked">是
                        <input type="radio" name="rruAway" id="rruAway" value="否">否
                        {{--<select name="rruAway" id="rruAway">--}}
                        {{--<option selected="selected">请选择...</option>--}}
                        {{--<option>是</option>--}}
                        {{--<option>否</option>--}}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        引电类型:
                    </th>
                    <td>
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="380V" checked="checked">380V
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="220V">220V
                    </td>
                </tr>
                <tr>
                    <th>
                        产品配套类型:
                    </th>
                    <td>
                        <input type="radio" name="productType" id="productType" value="铁塔+自有机房+配套" checked="checked">铁塔+自有机房+配套
                        <input type="radio" name="productType" id="productType" value="铁塔+租赁机房+配套">铁塔+租赁机房+配套
                        <input type="radio" name="productType" id="productType" value="铁塔+一体化机柜+配套">铁塔+一体化机柜+配套
                        <input type="radio" name="productType" id="productType" value="铁塔+RRU拉远+配套">铁塔+RRU拉远+配套
                        <input type="radio" name="productType" id="productType" value="铁塔(无机房及配套)">铁塔(无机房及配套)
                        {{--<select name="productType" id="productType">--}}
                        {{--<option selected="selected">请选择...</option>--}}
                        {{--<option>铁塔+自有机房+配套</option>--}}
                        {{--<option>铁塔+租赁机房+配套</option>--}}
                        {{--<option>铁塔+一体化柜+配套</option>--}}
                        {{--<option>铁塔+RRU拉远+配套</option>--}}
                        {{--<option>铁塔(无机房及配套)</option>--}}
                        {{--</select>--}}
                    </td>
                </tr>
                <tr>
                    <th>
                        铁塔类型:
                    </th>
                    <td>
                        <input type="radio" name="towerType" id="towerType" value="普通地面塔" checked="checked" onclick="towerTypeChange(this)">普通地面塔
                        <input type="radio" name="towerType" id="towerType" value="景观塔" onclick="towerTypeChange(this)">景观塔
                        <input type="radio" name="towerType" id="towerType" value="简易塔" onclick="towerTypeChange(this)">简易塔
                        <input type="radio" name="towerType" id="towerType" value="普通楼面塔" onclick="towerTypeChange(this)">普通楼面塔
                        <input type="radio" name="towerType" id="towerType" value="楼面抱杆" onclick="towerTypeChange(this)">楼面抱杆
                        {{--<select id="towerType" name="towerType" class="formText" onchange="towerTypeChange(this)">--}}
                        {{--<option selected="selected">请选择...</option>--}}
                        {{--<option>普通地面塔</option>--}}
                        {{--<option>景观塔</option>--}}
                        {{--<option>简易塔</option>--}}
                        {{--<option>普通楼面塔</option>--}}
                        {{--<option>楼面抱杆</option>--}}

                        {{--</select>--}}
                    </td>
                </tr>
                <tr>
                    <th>系统数量</th>
                    <td>
                        <input type="radio" name="sysNum" id="sysNum" value="1" checked="checked">1
                        <input type="radio" name="sysNum" id="sysNum" value="2">2
                        <input type="radio" name="sysNum" id="sysNum" value="3">3
                        <input type="radio" name="sysNum" id="sysNum" value="4">4
                        <input type="radio" name="sysNum" id="sysNum" value="5">5
                        {{--<select id="sysNum" name="sysNum" class="formText" onchange="sysNumChange(this)">--}}
                        {{--<option>请选择...</option>--}}
                        {{--<option>1</option>--}}
                        {{--<option>2</option>--}}
                        {{--<option>3</option>--}}
                        {{--<option>4</option>--}}
                        {{--<option>5</option>--}}
                        {{--</select>--}}
                    </td>
                </tr>
                <tr>
                    <th>
                        系统1挂高(m):
                    </th>
                    <td>
                        <div id="sysHeight1">
                            <div name="h0" style="float: left;"><input type="radio" name="sysHeight1" id="h0" value="无" checked="checked">无</div>
                            <div style="display: none;float: left;" name="h1"><input type="radio" name="sysHeight1" id="h1" value="H<20">H<20</div>
                            <div style="display: none;float: left" name="h2"><input type="radio" name="sysHeight1" id="h2" value="20<=H<25">20<=H<25</div>
                            <div style="display: none;float: left" name="h3"><input type="radio" name="sysHeight1" id="h3" value="25<=H<30">25<=H<30</div>
                            <div name="h4" style="float: left;"><input type="radio" name="sysHeight1" id="h4" value="H<30">H<30</div>
                            <div name="h5" style="float: left;"><input type="radio" name="sysHeight1" id="h5" value="30<=H<35">30<=H<35</div>
                            <div name="h6" style="float: left;"><input type="radio" name="sysHeight1" id="h6" value="35<=H<40">35<=H<40</div>
                            <div name="h7" style="float: left;"><input type="radio" name="sysHeight1" id="h7" value="40<=H<45">40<=H<45</div>
                            <div name="h8" style="float: left;"><input type="radio" name="sysHeight1" id="h8" value="45<=H<50">45<=H<50</div>
                            <div style="display: none;float: left" name="h9"><input type="radio" name="sysHeight1" id="h9" value="任意高度">任意高度</div>


                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        系统2挂高(m):
                    </th>
                    <td>
                        <div id="sysHeight2">
                            <div name="h0" style="float: left;"><input type="radio" name="sysHeight2" id="h0" value="无" checked="checked">无</div>
                            <div style="display: none;float: left;" name="h1"><input type="radio" name="sysHeight2" id="h1" value="H<20">H<20</div>
                            <div style="display: none;float: left" name="h2"><input type="radio" name="sysHeight2" id="h2" value="20<=H<25">20<=H<25</div>
                            <div style="display: none;float: left" name="h3"><input type="radio" name="sysHeight2" id="h3" value="25<=H<30">25<=H<30</div>
                            <div name="h4" style="float: left;"><input type="radio" name="sysHeight2" id="h4" value="H<30">H<30</div>
                            <div name="h5" style="float: left;"><input type="radio" name="sysHeight2" id="h5" value="30<=H<35">30<=H<35</div>
                            <div name="h6" style="float: left;"><input type="radio" name="sysHeight2" id="h6" value="35<=H<40">35<=H<40</div>
                            <div name="h7" style="float: left;"><input type="radio" name="sysHeight2" id="h7" value="40<=H<45">40<=H<45</div>
                            <div name="h8" style="float: left;"><input type="radio" name="sysHeight2" id="h8" value="45<=H<50">45<=H<50</div>
                            <div style="display: none;float: left" name="h9"><input type="radio" name="sysHeight2" id="h9" value="任意高度">任意高度</div>


                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        系统3挂高(m):
                    </th>
                    <td>
                        <div id="sysHeight3">
                            <div name="h0" style="float: left;"><input type="radio" name="sysHeight3" id="h0" value="无" checked="checked">无</div>
                            <div style="display: none;float: left;" name="h1"><input type="radio" name="sysHeight3" id="h1" value="H<20">H<20</div>
                            <div style="display: none;float: left" name="h2"><input type="radio" name="sysHeight3" id="h2" value="20<=H<25">20<=H<25</div>
                            <div style="display: none;float: left" name="h3"><input type="radio" name="sysHeight3" id="h3" value="25<=H<30">25<=H<30</div>
                            <div name="h4" style="float: left;"><input type="radio" name="sysHeight3" id="h4" value="H<30">H<30</div>
                            <div name="h5" style="float: left;"><input type="radio" name="sysHeight3" id="h5" value="30<=H<35">30<=H<35</div>
                            <div name="h6" style="float: left;"><input type="radio" name="sysHeight3" id="h6" value="35<=H<40">35<=H<40</div>
                            <div name="h7" style="float: left;"><input type="radio" name="sysHeight3" id="h7" value="40<=H<45">40<=H<45</div>
                            <div name="h8" style="float: left;"><input type="radio" name="sysHeight3" id="h8" value="45<=H<50">45<=H<50</div>
                            <div style="display: none;float: left" name="h9"><input type="radio" name="sysHeight3" id="h9" value="任意高度">任意高度</div>


                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        系统4挂高(m):
                    </th>
                    <td>
                        <div id="sysHeight4">
                            <div name="h0" style="float: left;"><input type="radio" name="sysHeight4" id="h0" value="无" checked="checked">无</div>
                            <div style="display: none;float: left;" name="h1"><input type="radio" name="sysHeight4" id="h1" value="H<20">H<20</div>
                            <div style="display: none;float: left" name="h2"><input type="radio" name="sysHeight4" id="h2" value="20<=H<25">20<=H<25</div>
                            <div style="display: none;float: left" name="h3"><input type="radio" name="sysHeight4" id="h3" value="25<=H<30">25<=H<30</div>
                            <div name="h4" style="float: left;"><input type="radio" name="sysHeight4" id="h4" value="H<30">H<30</div>
                            <div name="h5" style="float: left;"><input type="radio" name="sysHeight4" id="h5" value="30<=H<35">30<=H<35</div>
                            <div name="h6" style="float: left;"><input type="radio" name="sysHeight4" id="h6" value="35<=H<40">35<=H<40</div>
                            <div name="h7" style="float: left;"><input type="radio" name="sysHeight4" id="h7" value="40<=H<45">40<=H<45</div>
                            <div name="h8" style="float: left;"><input type="radio" name="sysHeight4" id="h8" value="45<=H<50">45<=H<50</div>
                            <div style="display: none;float: left" name="h9"><input type="radio" name="sysHeight4" id="h9" value="任意高度">任意高度</div>


                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        系统5挂高(m):
                    </th>
                    <td>
                        <div id="sysHeight5">
                            <div name="h0" style="float: left;"><input type="radio" name="sysHeight5" id="h0" value="无" checked="checked">无</div>
                            <div style="display: none;float: left;" name="h1"><input type="radio" name="sysHeight5" id="h1" value="H<20">H<20</div>
                            <div style="display: none;float: left" name="h2"><input type="radio" name="sysHeight5" id="h2" value="20<=H<25">20<=H<25</div>
                            <div style="display: none;float: left" name="h3"><input type="radio" name="sysHeight5" id="h3" value="25<=H<30">25<=H<30</div>
                            <div name="h4" style="float: left;"><input type="radio" name="sysHeight5" id="h4" value="H<30">H<30</div>
                            <div name="h5" style="float: left;"><input type="radio" name="sysHeight5" id="h5" value="30<=H<35">30<=H<35</div>
                            <div name="h6" style="float: left;"><input type="radio" name="sysHeight5" id="h6" value="35<=H<40">35<=H<40</div>
                            <div name="h7" style="float: left;"><input type="radio" name="sysHeight5" id="h7" value="40<=H<45">40<=H<45</div>
                            <div name="h8" style="float: left;"><input type="radio" name="sysHeight5" id="h8" value="45<=H<50">45<=H<50</div>
                            <div style="display: none;float: left" name="h9"><input type="radio" name="sysHeight5" id="h9" value="任意高度">任意高度</div>


                        </div>
                    </td>
                </tr>

                {{--<select id="sysHeight1" name="sysHeight1[]" class="formText" style="display: none">--}}
                {{--<option>请选择...</option>--}}
                {{--<option>H<30</option>--}}
                {{--<option>30<=H<35</option>--}}
                {{--<option>35<=H<40</option>--}}
                {{--<option>40<=H<45</option>--}}
                {{--<option>45<=H<50</option>--}}
                {{--</select>--}}

                {{--<select id="sysHeight2" name="sysHeight2[]" class="formText" style="display: none">--}}
                {{--<option>请选择...</option>--}}
                {{--<option>H<20</option>--}}
                {{--<option>20<=H<25</option>--}}
                {{--<option>25<=H<30</option>--}}
                {{--<option>30<=H<35</option>--}}
                {{--<option>35<=H<40</option>--}}
                {{--</select>--}}

                {{--<select id="sysHeight3" name="sysHeight3[]" class="formText" style="display: none;">--}}
                {{--<option>请选择...</option>--}}
                {{--<option>任意高度</option>--}}

                {{--</select>--}}

                {{--<select id="sysHeight4" name="sysHeight4[]" class="formText" style="display: none;">--}}
                {{--<option>请选择...</option>--}}
                {{--<option>任意高度</option>--}}
                {{--</select>--}}
                {{--</td>--}}
                {{--</tr>--}}
                {{--<tr id="sys2" style="display: none;">--}}
                    {{--<th>--}}
                        {{--系统2挂高(m):--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<select id="sysHeight1" name="sysHeight1[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                            {{--<option>40<=H<45</option>--}}
                            {{--<option>45<=H<50</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight2" name="sysHeight2[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<20</option>--}}
                            {{--<option>20<=H<25</option>--}}
                            {{--<option>25<=H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight3" name="sysHeight3[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}

                        {{--</select>--}}

                        {{--<select id="sysHeight4" name="sysHeight4[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr id="sys3" style="display: none;">--}}
                    {{--<th>--}}
                        {{--系统3挂高(m):--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<select id="sysHeight31" name="sysHeight1[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                            {{--<option>40<=H<45</option>--}}
                            {{--<option>45<=H<50</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight32" name="sysHeight2[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<20</option>--}}
                            {{--<option>20<=H<25</option>--}}
                            {{--<option>25<=H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight33" name="sysHeight3[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}

                        {{--</select>--}}

                        {{--<select id="sysHeight34" name="sysHeight4[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr id="sys4" style="display: none;">--}}
                    {{--<th>--}}
                        {{--系统4挂高(m):--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<select id="sysHeight41" name="sysHeight1[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                            {{--<option>40<=H<45</option>--}}
                            {{--<option>45<=H<50</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight42" name="sysHeight2[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<20</option>--}}
                            {{--<option>20<=H<25</option>--}}
                            {{--<option>25<=H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight43" name="sysHeight3[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}

                        {{--</select>--}}

                        {{--<select id="sysHeight44" name="sysHeight4[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr style="display: none" id="sys5">--}}

                    {{--<th>--}}
                        {{--系统5挂高(m):--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<select id="sysHeight51" name="sysHeight1[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                            {{--<option>40<=H<45</option>--}}
                            {{--<option>45<=H<50</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight52" name="sysHeight2[]" class="formText" style="display: none">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>H<20</option>--}}
                            {{--<option>20<=H<25</option>--}}
                            {{--<option>25<=H<30</option>--}}
                            {{--<option>30<=H<35</option>--}}
                            {{--<option>35<=H<40</option>--}}
                        {{--</select>--}}

                        {{--<select id="sysHeight53" name="sysHeight3[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}

                        {{--</select>--}}

                        {{--<select id="sysHeight54" name="sysHeight4[]" class="formText" style="display: none;">--}}
                            {{--<option>请选择...</option>--}}
                            {{--<option>任意高度</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}

                {{--</tr>--}}
                <tr>
                    <th>
                        覆盖场景:
                    </th>
                    <td>
                        <input type="radio" name="landForm" id="landForm" value="山区" checked="checked">山区
                        <input type="radio" name="landForm" id="landForm" value="平原">平原

                        {{--<select name="landForm" id="landForm">--}}
                            {{--<option selected="selected">请选择...</option>--}}
                            {{--<option>山区</option>--}}
                            {{--<option>平原</option>--}}
                        {{--</select>--}}
                    </td>
                </tr>
                <tr>
                    <th>
                        用户类型：
                    </th>
                    <td>
                        <input type="radio" name="userType" id="userType_old" value="锚定用户" checked="checked">锚定用户
                        {{--<input type="radio" name="userType" value="原产权">原产权--}}
                        <input type="radio" name="userType" id="userType_otheruser" value="其他用户">其他用户
                        {{--<input type="radio" name="userType" value="既有共享">既有共享--}}
                        {{--<input type="radio" name="userType" value="新增共享">新增共享--}}
                    </td>
                </tr>
                <tr>
                    <th>
                        铁塔共享类型:
                    </th>
                    <td>
                        <div name="shareType_1" style="float: left;"><input type="radio" name="shareType_tower" value="电信独享" checked="checked" >电信独享</div>
                        <div name="shareType_2" style="float: left;"><input type="radio" name="shareType_tower" value="两家共享">两家共享</div>
                        <div name="shareType_3" style="float: left;"><input type="radio" name="shareType_tower" value="三家共享">三家共享</div>
                    </td>
                </tr>
                <tr>
                    <th>
                        机房共享类型:
                    </th>
                    <td>
                        <div name="shareType_1" style="float: left;"><input type="radio" name="shareType_house" value="电信独享" checked="checked" >电信独享</div>
                        <div name="shareType_2" style="float: left;"><input type="radio" name="shareType_house" value="两家共享">两家共享</div>
                        <div name="shareType_3" style="float: left;"><input type="radio" name="shareType_house" value="三家共享">三家共享</div>
                    </td>
                </tr>
                <tr>
                    <th>
                        配套共享类型:
                    </th>
                    <td>
                        <div name="shareType_1" style="float: left;"><input type="radio" name="shareType_supporting" value="电信独享" checked="checked" >电信独享</div>
                        <div name="shareType_2" style="float: left;"><input type="radio" name="shareType_supporting" value="两家共享">两家共享</div>
                        <div name="shareType_3" style="float: left;"><input type="radio" name="shareType_supporting" value="三家共享">三家共享</div>
                    </td>
                </tr>
                <tr>
                    <th>
                        维护共享类型:
                    </th>
                    <td>
                        <div name="shareType_1" style="float: left;"><input type="radio" name="shareType_maintainence" value="电信独享" checked="checked" >电信独享</div>
                        <div name="shareType_2" style="float: left;"><input type="radio" name="shareType_maintainence" value="两家共享">两家共享</div>
                        <div name="shareType_3" style="float: left;"><input type="radio" name="shareType_maintainence" value="三家共享">三家共享</div>
                    </td>
                </tr>
                <tr>
                    <th>
                        场地费共享类型:
                    </th>
                    <td>
                        <div name="shareType_1" style="float: left;"><input type="radio" name="shareType_site" value="电信独享" checked="checked" >电信独享</div>
                        <div name="shareType_2" style="float: left;"><input type="radio" name="shareType_site" value="两家共享">两家共享</div>
                        <div name="shareType_3" style="float: left;"><input type="radio" name="shareType_site" value="三家共享">三家共享</div>
                    </td>
                </tr>
                <tr>
                    <th>
                        电力引入费共享类型:
                    </th>
                    <td>
                        <div name="shareType_1" style="float: left;"><input type="radio" name="shareType_import" value="电信独享" checked="checked" >电信独享</div>
                        <div name="shareType_2" style="float: left;"><input type="radio" name="shareType_import" value="两家共享">两家共享</div>
                        <div name="shareType_3" style="float: left;"><input type="radio" name="shareType_import" value="三家共享">三家共享</div>
                    </td>
                </tr>

                {{--<tr>--}}
                    {{--<th>--}}
                        {{--是否存在新增共享:--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="是" checked="checked">是--}}
                        {{--<input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="否">否--}}
                        {{--<select name="isNewlyAdded" id="isNewlyAdded">--}}
                            {{--<option selected="selected">请选择...</option>--}}
                            {{--<option>是</option>--}}
                            {{--<option>否</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            </table>
            <input type="button" value="提交" class="formButton" onclick="doAddSuccess()"/>
            <input type="button" value="返回" class="formButton" onclick="doBack()"/>
    </form>
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

        function doAddSuccess() {
            var siteCode = $('#siteCode').val();
            var establishedTime = $('#establishedTime').val();
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


            if(establishedTime == ''){
                alert('请输入服务起始日期！');
                return;
            }
            if(sys_Num == '1'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
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

        function doImport() {
            var siteInfoFile = document.getElementById('siteInfoFile');
            if (siteInfoFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteInfo/import')}}";
            listForm.submit();
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

        function userTypeChange(osel){
            var shareType_1 = document.getElementsByName('shareType_1');
            var shareType_2 = document.getElementsByName('shareType_2');
            var shareType_3 = document.getElementsByName('shareType_3');
            var shareType_tower = document.getElementsByName('shareType_tower');
            var shareType_house = document.getElementsByName('shareType_house');
            var shareType_supporting = document.getElementsByName('shareType_supporting');
            var shareType_maintainence = document.getElementsByName('shareType_maintainence');
            var shareType_site = document.getElementsByName('shareType_site');
            var shareType_import = document.getElementsByName('shareType_import');

            if (osel.value == '锚定用户' || osel.value == '原产权'){
                shareType_tower[0].checked = 'checked';
                shareType_house[0].checked = 'checked';
                shareType_supporting[0].checked = 'checked';
                shareType_maintainence[0].checked = 'checked';
                shareType_site[0].checked = 'checked';
                shareType_import[0].checked = 'checked';
                for(var i=0 ; i<shareType_1.length; i++){
                    shareType_1[i].style.display = 'inline';
                }
                for(var i=0 ; i<shareType_2.length; i++){
                    shareType_2[i].style.display = 'inline';
                }
                for(var i=0 ; i<shareType_3.length; i++){
                    shareType_3[i].style.display = 'inline';
                }

            }
            if (osel.value == '其他用户' || osel.value == '既有共享' || osel.value == '新增共享'){
                shareType_tower[1].checked = 'checked';
                shareType_house[1].checked = 'checked';
                shareType_supporting[1].checked = 'checked';
                shareType_maintainence[1].checked = 'checked';
                shareType_site[1].checked = 'checked';
                shareType_import[1].checked = 'checked';

                for(var i=0 ; i<shareType_1.length; i++){
                    shareType_1[i].style.display = 'none';
                }
                for(var i=0 ; i<shareType_2.length; i++){
                    shareType_2[i].style.display = 'inline';
                }
                for(var i=0 ; i<shareType_3.length; i++){
                    shareType_3[i].style.display = 'inline';
                }
            }

        }

        function shareTypeChange(osel) {
            var userType1 = document.getElementById('userType1');
            var userType2 = document.getElementById('userType2');
            var userType3 = document.getElementById('userType3');
            var userType4 = document.getElementById('userType4');
            var userType5 = document.getElementById('userType5');
            var userType_otheruser = document.getElementById('userType_otheruser');
            var userType_old = document.getElementById('userType_old');

            if (osel.value == '电信独享') {
                userType_old.checked = 'checked';
                userType1.style.display = 'inline';
                userType2.style.display = 'inline';
                userType3.style.display = 'none';
                userType4.style.display = 'none';
                userType5.style.display = 'none';

            }
            else {
                userType1.style.display = 'none';
                userType2.style.display = 'none';
                userType3.style.display = 'inline';
                userType_otheruser.checked = 'checked';
                userType4.style.display = 'inline';
                userType5.style.display = 'inline';
            }
        }

//        function sysNumChange(osel) {
//            var sys1 = document.getElementById('sys1');
//            var sys2 = document.getElementById('sys2');
//            var sys3 = document.getElementById('sys3');
//            var sys4 = document.getElementById('sys4');
//            var sys5 = document.getElementById('sys5');
//            if (osel.options[osel.selectedIndex].text == '1') {
//                sys1.style.display = '';
//                sys2.style.display = 'none';
//                sys3.style.display = 'none';
//                sys4.style.display = 'none';
//                sys5.style.display = 'none';
//            }
//            if (osel.options[osel.selectedIndex].text == '2') {
//                sys1.style.display = '';
//                sys2.style.display = '';
//                sys3.style.display = 'none';
//                sys4.style.display = 'none';
//                sys5.style.display = 'none';
//            }
//            if (osel.options[osel.selectedIndex].text == '3') {
//                sys1.style.display = '';
//                sys2.style.display = '';
//                sys3.style.display = '';
//                sys4.style.display = 'none';
//                sys5.style.display = 'none';
//            }
//            if (osel.options[osel.selectedIndex].text == '4') {
//                sys1.style.display = '';
//                sys2.style.display = '';
//                sys3.style.display = '';
//                sys4.style.display = '';
//                sys5.style.display = 'none';
//            }
//            if (osel.options[osel.selectedIndex].text == '5') {
//                sys1.style.display = '';
//                sys2.style.display = '';
//                sys3.style.display = '';
//                sys4.style.display = '';
//                sys5.style.display = '';
//            }
//
//        }

        function doBulkUpdate() {
            var siteInfoFile = document.getElementById('siteInfoToUpdateFile');
            if (siteInfoFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteInfo/bulkUpdate')}}";
            listForm.submit();
        }



    </script>
@endsection







