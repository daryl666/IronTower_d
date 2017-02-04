@extends('layouts.app')

@section('header')
    <title>站址信息列表</title>
@endsection

@section('script_header')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            var addBtn=document.getElementById("addBtn");
            var region = $('#region').val();
            addBtn.addEventListener('click',function(){
                var listForm=document.getElementById("listForm");
                var url = "{{url('backend/siteInfo/addNewPage')}}" + '/' + region;
                listForm.action= url;

            });
        });
    </script>
@endsection


@section('content')

    <div class="bar" style="font-weight:bold;">

        <a href="#">站址信息维护</a>
        <td>>>></td>
        <a href="#">站址信息查看</a>
    </div>

    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <td>
                        请选择地市来查看站址信息：
                    </td>
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
                        <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                    </td>

                    <td style="float:left;margin-right:30px;">
                        <input type="submit" class="formButton" value="新增站址" id="addBtn" style="float: right;"/>
                    </td>

                    {{--<td>--}}
                        {{--<input type="button" class="formButton" value="导出" onclick="doExport()" @if(isset($infoSites)) style="display: inline;" @endif style="display: none;"/>--}}
                    {{--</td>--}}

                </div>
            </form>
        </div>
        <div id="siteInfo">
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>站址编码</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>服务起始日期</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>地市</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>铁塔类型</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>是否为新建站</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>产品配套类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>是否为竞合站点</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>是否存在新增共享</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>用户类型</a>
                    </th>
                    <th class="gp">
                        <a href="#" class="sort" name="" hidefocus>覆盖场景</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>系统数量</a>
                    </th>
                    {{--<th class="scanStopTime">--}}
                        {{--<a href="#" class="sort" name="" hidefocus>系统挂高(米)</a>--}}
                    {{--</th>--}}
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>铁塔共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/月）（含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>机房共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>机房基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>机房基准价格（元/月）（含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>配套共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>配套基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>配套基准价格（元/月）（含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>维修共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>维修基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>维修基准价格（元/月）（含折扣）</a>
                    </th>
                    {{--<th class="freqMode">--}}
                        {{--<a href="#" class="sort" name="" hidefocus>站址所在地区类型</a>--}}
                    {{--</th>--}}
                    {{--<th class="freqMode">--}}
                        {{--<a href="#" class="sort" name="" hidefocus>是否RRU拉远</a>--}}
                    {{--</th>--}}
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>场地费共享类型</a>
                    </th>

                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>场地费（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>场地费（元/月）（含折扣）</a>
                    </th>
                    {{--<th class="freqMode">--}}
                        {{--<a href="#" class="sort" name="" hidefocus>引电类型</a>--}}
                    {{--</th>--}}
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>电力引入费共享类型</a>
                    </th>

                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>电力引入费（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>电力引入费（元/月）（含折扣）</a>
                    </th>

                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>扣费(元)</a>
                    </th>

                </tr>
                @if(isset($infoSites))
                @foreach($infoSites as $infoSite)
                    <tr>
                        {{--<td><a href="{{ url('backend/siteInfo/'.$infoSite->id.'/editPage')}}" class="">编辑</a></td>--}}
                        <td><a href="javascript:void(0)" onclick="doEditPage({{$infoSite->id}})">编辑</a></td>
                        <td>{{$infoSite->site_code}}</td>
                        <td>{{$infoSite->established_time}}</td>
                        <td>{{$infoSite->region_name}}</td>
                        <td>{{$infoSite->tower_type}}</td>
                        <td>{{$infoSite->is_new_tower}}</td>
                        <td>{{$infoSite->product_type}}</td>
                        <td>{{$infoSite->is_co_opetition}}</td>
                        <td>{{$infoSite->is_newly_added}}</td>
                        <td>{{$infoSite->user_type}}</td>
                        <td>{{$infoSite->land_form}}</td>

                        <td>{{$infoSite->sys_num}}</td>
                        {{--<td>{{$infoSite->sys1_height}}</td>--}}
                        <td>{{$infoSite->share_type_tow}}</td>
                        <td>{{$infoSite->fee_tow}}</td>
                        <td>{{$infoSite->fee_tow_disd}}</td>

                        <td>{{$infoSite->share_type_hou}}</td>
                        <td>{{$infoSite->fee_hou}}</td>
                        <td>{{$infoSite->fee_hou_disd}}</td>

                        <td>{{$infoSite->share_type_sup}}</td>
                        <td>{{$infoSite->fee_sup}}</td>
                        <td>{{$infoSite->fee_sup_disd}}</td>

                        <td>{{$infoSite->share_type_main}}</td>
                        <td>{{$infoSite->fee_main}}</td>
                        <td>{{$infoSite->fee_main_disd}}</td>

                        {{--<td>{{$infoSite->site_district_type}}</td>--}}
                        {{--<td>{{$infoSite->is_rru_away}}</td>--}}
                        <td>{{$infoSite->share_type_site}}</td>
                        {{--<td>{{$infoSite->site_sha_dis}}</td>--}}
                        <td>{{$infoSite->fee_site}}</td>
                        <td>{{$infoSite->fee_site_disd}}</td>

                        {{--<td>{{$infoSite->elec_introduced_type}}</td>--}}
                        <td>{{$infoSite->share_type_import}}</td>
                        {{--<td>{{$infoSite->import_sha_dis}}</td>--}}
                        <td>{{$infoSite->fee_import}}</td>
                        <td>{{$infoSite->fee_import_disd}}</td>

                        <td>0</td>

                    </tr>
                @endforeach
                    {{--{!! $infoSites->render() !!}--}}
                @endif


            </table>



        </div>




    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function() {

            $('#menu_site').addClass("current");
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

        function doExport(){
            var listForm=document.getElementById("listForm");
            listForm.action="{{url('backend/siteInfo/export')}}";
            listForm.submit();
        }

        function doImport(){
            var siteInfoFile = document.getElementById('siteInfoFile');
            if(siteInfoFile.value ==""){
                alert('请选择需要导入的文件');
                return;
            }
            var listForm=document.getElementById("listForm");
            listForm.action="{{url('backend/siteInfo/import')}}";
            listForm.submit();
        }

        function doEditPage(id){
            var region = $('#region').val();
            var listForm = document.getElementById('listForm');
            url = "{{url('backend/siteInfo/editPage')}}"+'/'+ id +'/' + region;
            listForm.action =url;
            listForm.submit();
        }


    </script>
@endsection