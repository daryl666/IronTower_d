@extends('layouts.app')

@section('header')
    <title>未出服务账单列表</title>
@endsection

@section('script_header')

@endsection


@section('content')
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{URL('backend/servBill/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <label style="font-size:15px;margin-bottom:10px">选择起止月份和地市来查看地区月账单：</label>
                    <table>
                        <tr>
                            <td>
                                统计起始时间:
                                <input type="text" id="beginDate" name="beginDate" style="width:130px;padding-left:5px"
                                       readonly="true"
                                       @if(isset($filter['beginDate'])) value="{{$filter['beginDate']}}" @endif
                                       onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                                ~
                                统计结束时间:
                                <input type="text" id="endDate" name="endDate" style="width:130px;padding-left:5px"
                                       readonly="true"
                                       @if(isset($filter['endDate'])) value="{{$filter['endDate']}}" @endif
                                       onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                地市：
                                @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='湖北省') selected="selected"
                                                @endif value="湖北省">湖北省
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                                @endif value="武汉">武汉
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                                @endif value="黄石">黄石
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                                @endif value="十堰">十堰
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                                @endif value="宜昌">宜昌
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                                @endif value="襄阳">襄阳
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                                @endif value="鄂州">鄂州
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                                @endif value="荆门">荆门
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                                @endif value="孝感">孝感
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                                @endif value="荆州">荆州
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                                @endif value="黄冈">黄冈
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                                @endif value="咸宁">咸宁
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                                @endif value="随州">随州
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                                @endif value="恩施">恩施
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                                @endif value="仙桃">仙桃
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                                @endif value="潜江">潜江
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                                @endif value="天门">天门
                                        </option>
                                        <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                                @endif value="林区">林区
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '武汉')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                                @endif value="武汉">武汉
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '黄石')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                                @endif value="黄石">黄石
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '十堰')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                                @endif value="十堰">十堰
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '宜昌')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                                @endif value="宜昌">宜昌
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '襄阳')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                                @endif value="襄阳">襄阳
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '鄂州')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                                @endif value="鄂州">鄂州
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '荆门')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                                @endif value="荆门">荆门
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '孝感')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                                @endif value="孝感">孝感
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '荆州')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                                @endif value="荆州">荆州
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '黄冈')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                                @endif value="黄冈">黄冈
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '咸宁')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                                @endif value="咸宁">咸宁
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '随州')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                                @endif value="随州">随州
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '恩施')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                                @endif value="恩施">恩施
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '仙桃')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                                @endif value="仙桃">仙桃
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '潜江')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                                @endif value="潜江">潜江
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '天门')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                                @endif value="天门">天门
                                        </option>
                                    </select>
                                @endif

                                @if(Auth::user()->area_level == '林区')
                                    <select name="region" id="region">
                                        <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                                @endif value="林区">林区
                                        </option>
                                    </select>
                                @endif
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;出账：
                                <input type="radio" name="out_status" value="0" checked="checked"/>未出账
                                <input type="radio" name="out_status" value="1"/>已出账
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="button" id="searchBtn" class="formButton" value="搜 索"
                                       onclick="doSearch()"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>

        <table class="listTable" style="white-space:nowrap;" id="servBill">
            <tr>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>地市</a>

                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>月份</a>

                </th>
                {{--<th>--}}
                {{--<a href="" class="sort">站址数量</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                {{--<a href="" class="sort">发电总次数</a>--}}
                {{--</th>--}}
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>发电费（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="objectRdn" hidefocus>月租服务费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">是否出账</a>
                </th>
                <th>
                    <a href="" class="sort">操作</a>
                </th>
            </tr>
            @foreach($feeouts as $feeout)
                <tr>
                    <td>{{($feeout->region_name)}}</td>
                    <td>{{$feeout->start_day.' - '.$feeout->end_day}}</td>
                    {{--<td>{{$feeout->site_num}}</td>--}}
                    {{--<td>{{$feeout->gnr_num}}</td>--}}
                    <td>
                        {{($feeout->fee_gnr)}}
                        <a href="javascript:viewBillGnrs('{{$feeout->id}}')">明细</a>
                    </td>
                    <td>
                        {{($feeout->fee_site)}}
                        <a href="javascript:viewBillSites('{{$feeout->id}}')">明细</a>
                    </td>
                    <td id="toGenBill">
                        {{transFeeOutStatus($feeout->is_out)}}
                    </td>
                    <td>
                        <button class="buttonNextStep" onclick="doOut('{{$feeout->id}}')">出账</button>
                    </td>
                </tr>
            @endforeach
            {{--@if($dayRange != '所有')--}}
                {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td>{{$dayRange}}未入账</td>--}}
                    {{--<td>--}}
                        {{--{{($fee_free->gnr_sum)}}--}}
                        {{--@if($fee_free->gnr_count = 0)--}}
                            {{--<a href="javascript:viewFreeGnrs()">明细</a>--}}
                        {{--@endif--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--无--}}
                    {{--</td>--}}
                    {{--<td id="toGenBill">--}}
                        {{--无--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--@if($fee_free->gnr_count = 0)--}}
                            {{--<button class="buttonNextStep" onclick="createFeeOut()">生成账单</button>--}}
                        {{--@endif--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endif--}}
            {{--<tr>--}}
                {{--<td></td>--}}
                {{--<td>累计未入账</td>--}}
                {{--<td>--}}
                    {{--金额：{{($fee_free_all->gnr_sum)}}；记录数：{{$fee_free_all->gnr_count}}--}}
                    {{--@if($fee_free->gnr_sum != 0)--}}
                        {{--<a href="javascript:viewFreeGnrs()">明细</a>--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--无--}}
                {{--</td>--}}
                {{--<td id="toGenBill">--}}
                    {{--无--}}
                {{--</td>--}}
                {{--<td>--}}
                {{--</td>--}}
            {{--</tr>--}}

        </table>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_bill').addClass("current");
        });

        function doSearch() {
            var region = $('#region').val();
            if (region == '') {
                alert('请选择所在区域');
                return;
            }
            var form = $('#listForm');
            form.submit();
        }

        function viewFreeGnrs() {
            var region = $('#region').val();
            if (region == '') {
                alert('请选择所在区域');
                return;
            }
            var beginDate = $('#beginDate').val();
            var endDate = $('#endDate').val();
            location.href = '{{URL('backend/servBill/freeGnr')}}' +
                    '?region=' + region + '&beginDate=' + beginDate + '&endDate=' + endDate;
        }

        function viewBillGnrs(id) {
            location.href = '{{URL('backend/servBill/billGnr')}}' + '?out_id=' + id;
        }

        function viewBillSites(id) {
            location.href = '{{URL('backend/servBill/site')}}' + '?out_id=' + id;
        }

        function createFeeOut() {
            var region = $('#region').val();
            if (region == '') {
                alert('请选择所在区域');
                return;
            }

            var beginDate = $('#beginDate').val();
            var endDate = $('#endDate').val();
            if (beginDate == '') {
                alert('请选择账单起始时间');
                return;
            }

            if (endDate == '') {
                alert('请选择账单结束时间');
                return;
            }
            if (beginDate > endDate) {
                alert('账单起始时间不能大于结束时间');
                return;
            }

            $.post(
                    "{{URL('backend/servBill/createBill')}}",
                    {
                        beginDate: beginDate,
                        endDate: endDate,
                        region: region,
                        _token: '{{ csrf_token() }}'
                    },
                    function (data) {
//                    var tmp = JSON.parse(data);
                        var tmp = data;
                        if (tmp.code == 0) {
                            // 刷新本页面
                            var form = $('#listForm');
                            form.submit();
                        } else {
                            alert('账单创建失败，请联系管理员');
                        }
                    });
        }

        function doOut(id) {
            // 出账
            $.post(
                    "{{URL('backend/servBill/doOut')}}",
                    {
                        out_id: id,
                        _token: '{{ csrf_token() }}'
                    },

                    function (data) {
//                    var tmp = JSON.parse(data);
                        var tmp = data;
                        if (tmp.code == 0) {
                            // 刷新本页面
                            var form = $('#listForm');
                            form.submit();
                        }
                        if(tmp.code == 500){
                            alert('没有权限，请联系管理员！')
                        }
//                        else {
//                            alert('出账操作失败，请联系管理员');
//                        }
                    });
        }
    </script>
@endsection