<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')

    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/jquery.waiting.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/base.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/admin.css') }}"/>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.waiting.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/base.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.pager.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/datePicker/WdatePicker.js') }}"></script>
    <script type="text/javascript">
        $().ready(function () {
            // 显示时间
            showTime();
        })

        function showTime() {
            var date = new Date(); //日期对象
            var now = "";
            now = date.getFullYear() + "/";
            now = now + (date.getMonth() + 1) + "/";
            now = now + date.getDate() + "  ";
            now = now + date.getHours() + ":";
            now = now + date.getMinutes() + ":";
            now = now + date.getSeconds();
            $("#nowTime").html(now);
            setTimeout("showTime()", 1000);
        }
    </script>
    @yield('script_header')
</head>
<body>
@if (session('status_update'))
    <div class="alert alert-success" style="">
        <script language=javascript>
            alert('修改成功！');
            <?php ?>
        </script>

    </div>
@endif


<div class="header">
    <table width="100%">
        <tr>
            <td width="165px">
                <div class="bodyLeft">
                    <div class="logo"></div>
                </div>
            </td>
            <td>
                <div class="bodyRight" style="width:100%">
                    <div class="link">
                        &nbsp;
                    </div>
                    <table width="100%" style="white-space:norwap;">
                        <tr>
                            <td>
                                <div id="menu" class="menu">
                                    <ul style="margin-left:10px">
                                        <li class="menuItem" id="menu_index">
                                            <a href="{{url('backend/')}}">首页</a>
                                        </li>
                                        <li class="menuItem" id="menu_site">
                                            <a href="{{url('backend/siteInfo')}}">站址信息维护</a>
                                        </li>
                                        <li class="menuItem" id="rent_std">
                                            <a href="{{url('backend/rentStd')}}">月租标准查询</a>
                                        </li>
                                        <li class="menuItem" id="menu_cost">
                                            <a href="{{url('backend/servCost')}}">服务费用填报</a>
                                        </li>
                                        {{--<li class="menuItem" id="menu_gnr">--}}
                                            {{--<a href="{{url('backend/gnrRec')}}">发电记录填报</a>--}}
                                        {{--</li>--}}
                                        <li class="menuItem" id="menu_bill">
                                            <a href="{{url('backend/servBill')}}">服务账单管理</a>
                                        </li>
                                        <li class="menuItem" id="menu_other">
                                            <a href="{{url('backend/otherCost')}}">其他费用填报</a>
                                        </li>
                                        {{--<li class="menuItem" id="menu_elecCharge">--}}
                                        {{--<a href="{{url('backend/elecCharge')}}">日常电费填报</a>--}}
                                        {{--</li>--}}
                                        @if(Auth::user()->area_level == 'admin')
                                        <li class="menuItem" id="menu_userManage">
                                            <a href="{{url('backend/userManage')}}">用户管理</a>
                                        </li>
                                            @endif
                                    </ul>
                                </div>
                            </td>
                            <td style="text-align:right">
                                <div class="info" style="margin-right:10px;font-size: 12px">
                                        <span class="welcome" style="color:#CD3700">
                                            账号:&nbsp;{{ Auth::user()->name }}&nbsp;
                                            地区:&nbsp;{{Auth::user()->area_level}}&nbsp;
                                            时间:&nbsp;<span id="nowTime"></span>
                                        </span>
                                    <a class="logout" href="{{ url('logout') }}" target="_top">退出</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

@yield('content')
@yield('script_footer')
</body>
</html>