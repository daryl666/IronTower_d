<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Models\ServPrice;


class UserManageController extends Controller
{
    public function indexPage(Request $request){
        $users = DB::table('users')->get();
        return view('backend/userManage/index')->with('users',$users);
    }

    public function verifyPermission(Request $request, $id){
        $view = 0;
        $bulk_export = 0;
        $bulk_import = 0;
        $bulk_update = 0;
        $single_update = 0;
        $delete = 0;
        $account_out = 0;
        if(!empty($request->get('permission_'.$id))){
            foreach ($request->get('permission_'.$id) as $permission){
                if ($permission == 'view'){
                    $view = 1;
                }
                if ($permission == 'bulk_export'){
                    $bulk_export = 1;
                }
                if ($permission == 'bulk_import'){
                    $bulk_import = 1;
                }
                if ($permission == 'bulk_update'){
                    $bulk_update = 1;
                }
                if ($permission == 'single_update'){
                    $single_update = 1;
                }
                if ($permission == 'delete'){
                    $delete = 1;
                }
                if ($permission == 'account_out') {
                    $account_out = 1;
                }
            }
        }
        $update_success = DB::table('users')->where('id', $id)->update([
            'view' => $view,
            'bulk_export' => $bulk_export,
            'bulk_import' => $bulk_import,
            'bulk_update' => $bulk_update,
            'single_update' => $single_update,
            'delete' => $delete,
            'is_verified' => 1,
            'account_out' => $account_out,
        ]);
        if($update_success){
            echo "<script>alert('审核成功！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }else{
            echo "<script>alert('审核失败！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }
    }

    public function updatePermission(Request $request, $id){
        $view = 0;
        $bulk_export = 0;
        $bulk_import = 0;
        $bulk_update = 0;
        $single_update = 0;
        $delete = 0;
        $account_out = 0;
        if(!empty($request->get('permission_'.$id))) {
            foreach ($request->get('permission_' . $id) as $permission) {
                if ($permission == 'view') {
                    $view = 1;
                }
                if ($permission == 'bulk_export') {
                    $bulk_export = 1;
                }
                if ($permission == 'bulk_import') {
                    $bulk_import = 1;
                }
                if ($permission == 'bulk_update') {
                    $bulk_update = 1;
                }
                if ($permission == 'single_update') {
                    $single_update = 1;
                }
                if ($permission == 'delete') {
                    $delete = 1;
                }
                if ($permission == 'account_out') {
                    $account_out = 1;
                }
            }
        }
        $update_success = DB::table('users')->where('id', $id)->update([
            'view' => $view,
            'bulk_export' => $bulk_export,
            'bulk_import' => $bulk_import,
            'bulk_update' => $bulk_update,
            'single_update' => $single_update,
            'delete' => $delete,
            'account_out' => $account_out,
        ]);
        if($update_success){
            echo "<script>alert('修改成功！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }else{
            echo "<script>alert('修改失败！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }
    }


}
