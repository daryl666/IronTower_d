@extends('layouts.app')

@section('header')
    <title>发电记录填报</title>
    @endsection


@section('script_header')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            {{--var confirmBtn=document.getElementById("confirmBtn");--}}
            {{--confirmBtn.addEventListener('click',function(){--}}
                {{--var siteChoose = document.getElementsByName('siteChoose');--}}
                {{--for(var i=0; i < siteChoose.length; i++){--}}
                    {{--if(siteChoose[i].checked == true)--}}
                    {{--{--}}
                        {{--var listForm=document.getElementById("listForm");--}}
                        {{--listForm.action="{{url('backend/gnrRec/indexGnr')}}";--}}
                        {{--listForm.submit();--}}
                    {{--}--}}
                    {{--else if(i == siteChoose.length - 1&&siteChoose[i].checked == false)--}}
                    {{--{--}}
                        {{--alert('请先选择站址！');--}}
                        {{--return;--}}
                    {{--}--}}


                {{--}--}}

            {{--});--}}
//            var queryBtn = document.getElementById('queryBtn');
//            queryBtn.addEventListener('click',function(){
//                confirmBtn.style.display = 'block';
//            });
            var addBtn=document.getElementById("addBtn");
            addBtn.addEventListener('click',function(){
                var listForm=document.getElementById("listForm");
                listForm.action="{{url('backend/gnrRec/addPage')}}";
            });
//            var siteChoose = document.getElementsByName('siteChoose');
//            for(var i=0; i < siteChoose.length; i++){
//                siteChoose.addEventListener('click',function(){
//                    confirmBtn.style.display = 'block';
//                });
//
//                }
        });

    </script>
    @endsection
@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="#">发电记录填报</a>
        <td>>>></td>
        <a href="#">发电记录查询</a>
    </div>

    <div class="list">
        <form id="listForm" method="post" action="{{url('backend/gnrRec/')}}" enctype="multipart/form-data">
        <div class="body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="siteID" @if(isset($siteInfos)) value="{{$siteInfos[0]->id}}"@endif>
            <input type="hidden" name="sitechoose" @if(isset($filter['siteChoose'])) value="{{$filter['siteChoose']}}" @endif>
            <input type="hidden" name="lastGnrTime" @if(!empty($siteInfos[0]->last_gnr_time)) value="{{$siteInfos[0]->last_gnr_time}}" @endif>
            <input type="hidden" name="siteAddress" @if(!empty($siteInfos[0]->site_address)) value="{{$siteInfos[0]->site_address}}" @endif>
            <input type="hidden" name="region_export" @if(!empty($siteInfos[0]->region_name)) value="{{$siteInfos[0]->region_name}}" @endif>
            <input type="hidden" name="siteCode_export" @if(!empty($siteInfos[0]->site_code)) value="{{$siteInfos[0]->site_code}}" @endif>

                <div class="listBar">
                    <td>请选择区县查看并选定站址：</td>
                    <td>
                        @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='湖北省') selected="selected" @endif value="湖北省">湖北省</option>
                                <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected" @endif value="武汉">武汉</option>
                                <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected" @endif value="黄石">黄石</option>
                                <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected" @endif value="十堰">十堰</option>
                                <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected" @endif value="宜昌">宜昌</option>
                                <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected" @endif value="襄阳">襄阳</option>
                                <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected" @endif value="鄂州">鄂州</option>
                                <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected" @endif value="荆门">荆门</option>
                                <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected" @endif value="孝感">孝感</option>
                                <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected" @endif value="荆州">荆州</option>
                                <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected" @endif value="黄冈">黄冈</option>
                                <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected" @endif value="咸宁">咸宁</option>
                                <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected" @endif value="随州">随州</option>
                                <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected" @endif value="恩施">恩施</option>
                                <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected" @endif value="仙桃">仙桃</option>
                                <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected" @endif value="潜江">潜江</option>
                                <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected" @endif value="天门">天门</option>
                                <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected" @endif value="林区">林区</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '武汉')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected" @endif value="武汉">武汉</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '黄石')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected" @endif value="黄石">黄石</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '十堰')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected" @endif value="十堰">十堰</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '宜昌')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected" @endif value="宜昌">宜昌</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '襄阳')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected" @endif value="襄阳">襄阳</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '鄂州')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected" @endif value="鄂州">鄂州</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '荆门')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected" @endif value="荆门">荆门</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '孝感')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected" @endif value="孝感">孝感</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '荆州')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected" @endif value="荆州">荆州</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '黄冈')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected" @endif value="黄冈">黄冈</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '咸宁')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected" @endif value="咸宁">咸宁</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '随州')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected" @endif value="随州">随州</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '恩施')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected" @endif value="恩施">恩施</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '仙桃')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected" @endif value="仙桃">仙桃</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '潜江')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected" @endif value="潜江">潜江</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '天门')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected" @endif value="天门">天门</option>
                            </select>
                        @endif

                        @if(Auth::user()->area_level == '林区')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected" @endif value="林区">林区</option>
                            </select>
                        @endif
                    </td>



                    <td>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="queryBtn" class="formButton" value="查询" hidefocus onclick="doSearch()" @if(isset($filter['siteChoose'])) style="display: none" @endif/>
                    </td>
                    <td>
                        <input type="button" value="确认" id="confirmBtn" class="formButton" style="display: none;" @if(isset($filter['siteChoose'])) style="display: none" @endif onclick="doConfirm()">
                    </td>

                </div>
        </div>
        <div id="siteInfo">
            <table class="listTable" style="white-space:nowrap;font-size: 12px;">
                {{--<tr>--}}

                    {{--<label style="margin-right:10px;font-size:15px;">你可以输入站址编码进行过滤</label>--}}
                    {{--<input type="text" style="width:100px;">--}}
                    {{--<button class="buttonNextStep" id="filter" style="margin:5px">过滤</button>--}}

                {{--</tr>--}}
                <tr>
                    <th @if(isset($filter['siteChoose'])) style="display: none" @endif>
                        <a href="#" class="sort" name="" hidefocus>选择</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>地市</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>站址编码</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>详细地址</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>计价规则</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>发电总时长（时:分）</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>发电次数</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>发电总费用（元）（不含税）</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>发电总费用（元）（含税）</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>最近一次发电时间</a>
                    </th>
                </tr>
                @if(isset($siteInfos))
                    @foreach($siteInfos as $infoSite)
                        {{--@if(!empty($infoSite->last_gnr_time))--}}
                        <tr>
                            <td @if(isset($filter['siteChoose'])) style="display: none" @endif><input type="radio" name="siteChoose" value="{{$infoSite->id}}" onclick="doChoose()"/></td>
                            <td>{{$infoSite->region_name}}</td>
                            <td>{{$infoSite->site_code}}</td>
                            <td>{{$infoSite->site_address}}</td>
                            <td>
                                @if($infoSite->land_form == '山区') 五小时以内收费270元，超出部分每小时20元 @endif
                                @if($infoSite->land_form == '平原') 五小时以内收费220元，超出部分每小时20元 @endif
                            </td>
                            <td>@if(isset($infoSite->gnr_total_len)) {{$infoSite->gnr_total_len}}@endif</td>
                            <td>@if(isset($infoSite->gnr_num)) {{$infoSite->gnr_num}}@endif</td>
                            <td>@if(isset($infoSite->gnr_total_fee)) {{$infoSite->gnr_total_fee}}@endif</td>
                            <td>@if(isset($infoSite->gnr_total_fee_taxed)) {{$infoSite->gnr_total_fee_taxed}}@endif</td>
                            <td>
                                @if(isset($infoSite->last_gnr_time)) {{$infoSite->last_gnr_time}} @endif
                            </td>

                        </tr>
                        {{--@endif--}}
                    @endforeach
                @endif

            </table>


        </div>

        <div @if(isset($filter['siteChoose'])) style="display: block" @endif style="margin-top:20px;display: none;">
            <hr>
            <div style="float:left;margin:5px">
                请编辑或新增发电记录
            </div>
            <input type="submit" class="formButton" value="新增记录" id="addBtn"/>
            <input type="button" class="formButton" value="导出" onclick="doExport()"/>
            <table class="listTable" style="white-space:nowrap;margin-top:10px;font-size: 12px;">
                <tr>
                    <th>
                        <a href="#" class="sort">操作</a>
                    </th>
                    <th>
                        <a href="#" class="sort">提交时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort">发电起始时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort">发电终止时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort">发电时长（时:分）</a>
                    </th>
                    <th>
                        <a href="#" class="sort">发电费用（元）（不含税）</a>
                    </th>
                    <th>
                        <a href="#" class="sort">发电费用（元）（含税）</a>
                    </th>

                </tr>
                @if(isset($gnrRecs))
                    @foreach($gnrRecs as $gnrRec)
                        <tr @if(strtotime($gnrRec->gnr_len) < strtotime('00:15') || strtotime($gnrRec->gnr_len) > strtotime('20:00')) style="color: red" @endif>
                            <td><a href="{{ url('backend/gnrRec/'.$gnrRec->id.'/editPage/'.$siteInfos[0]->id.'/'.$filter['siteChoose'].'/'.$siteInfos[0]->last_gnr_time)}}" class="">编辑</a></td>
                            <td @if(isset($filter['siteChoose'])) style="display: none" @endif><input type="radio" name="siteChoose" value="{{$infoSite->id}}"/></td>
                            <td>{{$gnrRec->created_at}}</td>
                            <td>{{$gnrRec->gnr_start_time}}</td>
                            <td>{{$gnrRec->gnr_stop_time}}</td>
                            <td>{{$gnrRec->gnr_len}}</td>
                            <td>{{$gnrRec->gnr_fee}}</td>
                            <td>{{$gnrRec->gnr_fee_taxed}}</td>


                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </form>
    </div>
    @endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function() {
            $('#menu_gnr').addClass("current");
        });

        function doSearch(){
            var region = $('#region').val();
            if(region == '请选择...'){
                alert('请选择所在区域');
                return;
            }
            var form = $('#listForm');
            form.submit();
        }

        function doConfirm(){
            var region = $('#region').val();
            if(region == '请选择...'){
                alert('请选择所在区域');
                return;
            }
            else{
                var siteChoose = document.getElementsByName('siteChoose');
                if(siteChoose.length == 0){
                    alert('请先查询站址！');
                    return;
                }
                else{
                    for(var i=0; i < siteChoose.length; i++){
                        if(siteChoose[i].checked == true)
                        {
                            var listForm=document.getElementById("listForm");
                            listForm.action="{{url('backend/gnrRec/indexGnr')}}";
                            listForm.submit();
                            return;
                        }
                    }
                    if(siteChoose[siteChoose.length-1].checked == false){
                        alert('请先选择站址！')
                    }

                }

            }

        }

        function doChoose(){
            var confirmBtn = document.getElementById('confirmBtn');
            confirmBtn.style.display="inline";
        }

        function doExport(){
            var listForm=document.getElementById("listForm");
            listForm.action="{{url('backend/gnrRec/export')}}";
            listForm.submit();
        }


    </script>
@endsection
