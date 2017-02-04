@extends('layouts.app')

@section('header')
    <title>站址信息新增</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">其他费用填报</a>
        <td>>>></td>
        <a href="#">其他费用查询</a>
    </div>

    <div class="list">
        <div class="body">
        <form id="listForm" method="post" action="{{url('backend/otherCost/')}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="listBar">
                <td>
                    请选择地市来查看站址其他费用：
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
                    <input type="button" class="formButton" value="新增费用" id="addBtn" style="float: right;" onclick="doAddPage()"/>
                </td>



            </div>
        </form>
        </div>
        <div>
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>站址编码</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>地市</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>wlan费用(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>微波费用(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>超过10%高等级服务站址额外维护服务费(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>蓄电池额外保障费(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>bbu安装在铁塔机房费(元/月)</a>
                    </th>

                </tr>
                @if(isset($otherCosts))
                    @foreach($otherCosts as $otherCost)
                        <tr>
                            <td><a href="javascript:void(0)" onclick="doEditPage({{$otherCost->id}})">编辑</a></td>
                            <td>{{$otherCost->site_code}}</td>
                            <td>{{$otherCost->region_name}}</td>
                            <td>{{$otherCost->fee_wlan}}</td>
                            <td>{{$otherCost->fee_micwav}}</td>
                            <td>{{$otherCost->fee_add}}</td>
                            <td>{{$otherCost->fee_bat}}</td>
                            <td>{{$otherCost->fee_bbu}}</td>


                        </tr>
                    @endforeach

                @endif


            </table>



        </div>
    </div>

    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_other').addClass("current");
        });
         function doSearch(){
             var form = document.getElementById('listForm');
             form.submit();
         }

         function doAddPage(){
             var form = document.getElementById('listForm');
             form.action = "{{url('backend/otherCost/addPage')}}";
             form.submit();
         }

         function doEditPage(id){
             var region = $('#region').val();
             var form = document.getElementById('listForm');
             var url = "{{url('backend/otherCost/editPage')}}" + '/' + id + '/' + region;
             form.action = url;
             form.submit();
         }

    </script>
@endsection







