<?php
/**
 * Created by PhpStorm.
 * User:
 */

/*金额按元显示*/
if (! function_exists('formatNumber')) {

    function formatNumber($number){
        if($number == 0)
            return 0;
        return sprintf("%.0f", $number*10000);
    }

}

/*商品类型字段定义*/
if (! function_exists('transFeeOutStatus')) {

    function transFeeOutStatus($post_type){
        $map = [
            0 => '未出账',
            1 => '已出账',
        ];

        if($post_type==='all'){
            return $map;
        }


        if(isset($map[$post_type])){
            return $map[$post_type];
        }

        return '';

    }

}