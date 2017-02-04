@extends('layouts.app')

@section('header')
    <title>服务账单明细</title>
@endsection

@section('script_header')

@endsection

@section('content')
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" target="_self">
                <div class="listBar">
                    <label>【地市】: </label>
                    <input type="text" id="region" disabled="disabled" value="{{$bill->region_name}}">
                    <label>【账单日期】: </label>
                    <input type="text" id="region" disabled="disabled" value="{{$bill->start_day.' - '.$bill->end_day}}">
                    <input type="button" class="formButton" onclick="history.back()" value="返回" style="float: right">
                    {{--<a href="{{URL('backend/servBill/')}}?out_status={{$bill->is_out}}&region={{$region}}&beginDate={{$bill->start_day}}&endDate={{$bill->end_day}}" class="buttonNextStep" style="float:right">返回</a>--}}
                </div>
            </form>
        </div>
        <hr>
        <div style="font-size:15px;margin:10px;">
            【月租服务费】
        </div>
        <table class="listTable" style="white-space:nowrap;">
            <tr>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>序号</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>站址编码</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>铁塔基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>机房基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>配套基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>维护费基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="objectRdn" hidefocus>场地费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">电力引入费（元）</a>
                </th>
            </tr>
            @for ($i = 0; $i < count($sites); $i++)
                <tr>
                    <td>{{($i + 1)}}</td>
                    <td>{{$sites[$i]->site_code}}</td>
                    <td>{{($sites[$i]->fee_tow)}}</td>
                    <td>{{($sites[$i]->fee_hou)}}</td>
                    <td>{{($sites[$i]->fee_sup)}}</td>
                    <td>{{($sites[$i]->fee_main)}}</td>
                    <td>{{($sites[$i]->fee_site)}}</td>
                    <td>{{($sites[$i]->fee_import)}}</td>
                </tr>
            @endfor
        </table>
    </div>
@endsection


@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function() {
            $('#menu_bill').addClass("current");
        });

    </script>
@endsection
