@extends('layouts.app')

@section('header')
    <title>首页</title>
    @endsection

@section('content')
    <div class="list">
        <div style="float:left;font-size:15px;margin-top:5px">
            欢迎登陆铁塔租赁费用管理系统！
        </div>
    </div>
    @endsection




@section('script_footer')
    <script type="text/javascript">
        $().ready(function() {

            $('#menu_index').addClass("current");
        });
    </script>
@endsection