@extends('layouts.app')

@section('header')
    <title>新增发电记录</title>
@endsection

@section('script_header')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            var backBtn = document.getElementById("backBtn");
            backBtn.addEventListener('click', function () {
                var listForm = document.getElementById("listForm");
                listForm.action = "{{url('backend/gnrRec/back')}}";

            });
        });
    </script>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">发电记录填报</a>
        <td>>>></td>
        <a href="#">发电记录新增</a>
    </div>

    <body class="input managerInfo">
    <div class="list">
        <div>
            <div class="bar">
                <label style="">站址信息</label>
            </div>
        </div>
        <table class="listTable" style="white-space:nowrap;">
            <tr>
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
                    <a href="#" class="sort" name="" hidefocus>发电总时长</a>
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
                    <tr>
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
                        <td>@if(isset($infoSite->gnr_total_fee)) {{$infoSite->gnr_total_fee_taxed}}@endif</td>
                        <td>
                            @if(isset($infoSite->last_gnr_time)) {{$infoSite->last_gnr_time}} @endif
                        </td>

                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <form id="listForm" method="post" action="{{url('backend/gnrRec/add')}}" enctype="multipart/form-data">
        <input type="hidden" name="id" value="${id}"/>
        <input type="hidden" name="siteChoose" value="{{$sitechoose}}">
        <input type="hidden" name="siteCode" value="{{$siteInfos[0]->site_code}}">
        <input type="hidden" name="region" value="{{$siteInfos[0]->region_name}}">
        <input type="hidden" name="lastGnrTime" value="{{$siteInfos[0]->last_gnr_time}}">
        {!! csrf_field() !!}
        <div class="input managerInfo">
            <div class="bar">
                批量导入
            </div>
            <table class="inputTable tabContent">
                <tr>

                    <td>
                        <input type="file" name="gnrRecFile" style="width: 170px" id="gnrRecFile">
                        <input type="button" class="formButton" value="导入" onclick="doImport()"/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="body">

            <hr>
            <div style="margin:10px;">
                请输入发电信息
            </div>
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        发电起始时间:
                    </th>
                    <td>

                        <input type="text" id="beginDate" name="startTime" style="width:130px;padding-left:5px"
                               readonly="true" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>


                    </td>
                </tr>
                <tr>
                    <th>
                        发电终止时间:
                    </th>
                    <td>
                        <input type="text" id="endDate" name="stopTime" style="width:130px;padding-left:5px"
                               readonly="true" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
                    </td>
                </tr>


            </table>
            <input type="button" value="提交" class="formButton" onclick="doAdd()">
            <input type="button" value="返回" class="formButton" onclick="doBack()">


        </div>
    </form>
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_gnr').addClass("current");
        });

        function doAdd() {
            var beginDate = $('#beginDate').val();
            var endDate = $('#endDate').val();
            if (beginDate == '') {
                alert('请输入发电起始时间！');
                return;
            }
            if (endDate == '') {
                alert('请输入发电终止时间！');
                return;
            }
            if (beginDate > endDate) {
                alert('发电终止时间必须大于起始时间！');
                return;
            }
            if (confirm('确认提交吗？')) {
                var form = $('#listForm');
                form.submit();
            }


        }

        function doBack() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec/back')}}";
            listForm.submit();
        }

        function doImport() {
            var gnrRecFile = document.getElementById('gnrRecFile');
            if (gnrRecFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec/import')}}";
            listForm.submit();
        }


    </script>
@endsection