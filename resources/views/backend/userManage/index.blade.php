@extends('layouts.app')

@section('header')
    <title>用户管理</title>
@endsection

@section('content')
    <div class="list">
        <div class="body">
    <form id="listForm" method="post" action="{{url('backend/userManage/update')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <table class="listTable" style="white-space:nowrap;font-size:12px;">
            <tr>
                <th>
                    <a href="#" class="sort" name="" hidefocus>用户级别</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>用户名</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>权限</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>状态</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>操作</a>
                </th>
            </tr>
            @if(isset($users))
                @foreach($users as $user)
                    @if($user->area_level != 'admin')
                    <tr>
                        <td>{{$user->area_level}}</td>
                        <td>{{$user->name}}</td>
                        <td>
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="view" @if($user->view == 1) checked="checked"@endif>查看
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="single_update" @if($user->single_update == 1) checked="checked"@endif>逐个修改
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="delete" @if($user->delete == 1) checked="checked"@endif>删除
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="bulk_import" @if($user->bulk_import == 1) checked="checked"@endif>批量导入
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="bulk_export" @if($user->bulk_export == 1) checked="checked"@endif>批量导出
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="bulk_update" @if($user->bulk_update == 1) checked="checked"@endif>批量修改
                            <input type="checkbox" name="permission_{{$user->id}}[]" value="account_out" @if($user->account_out == 1) checked="checked"@endif>出账
                        </td>
                        <td>
                            @if($user->is_verified == 1)已审核@endif
                            @if($user->is_verified == 0)待审核@endif
                        </td>
                        <td>
                            @if($user->is_verified == 1)<input type="button" value="修改权限" onclick="doUpdate({{$user->id}})">@endif
                            @if($user->is_verified == 0)<input type="button" value="审核通过" onclick="doVerify({{$user->id}})">@endif
                        </td>
                    </tr>
                    @endif
                @endforeach
            @endif


        </table>
    </form>
        </div>
    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function() {

            $('#menu_userManage').addClass("current");
        });

        function doVerify(id){
            var listForm = document.getElementById('listForm');
            var url = "{{url('backend/userManage/verify')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }
        function doUpdate(id){
            var listForm = document.getElementById('listForm');
            var url = "{{url('backend/userManage/update')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

    </script>
@endsection







