<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/10/1 下午7:13
 *  +----------------------------------------------------------------------
 *  | Description:   时间处理函数
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;


class DateHelper
{
    /**
     * 传入时间戳,计算距离现在的时间
     * @param  number $time 时间戳
     * @return string     返回多少以前
     */
    static public function format_time($time) {
        $time = (int) substr($time, 0, 10);
        $int = time() - $time;
        $str = '';
        if ($int <= 2){
            $str = sprintf('刚刚', $int);
        }elseif ($int < 60){
            $str = sprintf('%d秒前', $int);
        }elseif ($int < 3600){
            $str = sprintf('%d分钟前', floor($int / 60));
        }elseif ($int < 86400){
            $str = sprintf('%d小时前', floor($int / 3600));
        }elseif ($int < 1728000){
            $str = sprintf('%d天前', floor($int / 86400));
        }elseif ($int < 20736000){
            $moth = floor($int / 1728000);
            if($moth<=3){
                $str = sprintf('%d月前', $moth);
            }else{
                $str = date('m月d日 H:i', $time);
            }

        }else{
            $str = date('Y年m月d日 H:i', $time);
        }
        return $str;
    }
    /**
     * @start time 程序执行开始时间
     */
    static public function proStartTime() {
        global $startTime;
        $mtime1 = explode(" ", microtime());
        $startTime = $mtime1[1] + $mtime1[0];
    }

    /**
     * @End time 程序执行结束时间
     */
    static public function proEndTime() {
        global $startTime,$set;
        $mtime2 = explode(" ", microtime());
        $endtime = $mtime2[1] + $mtime2[0];
        $totaltime = ($endtime - $startTime);
        $totaltime = number_format($totaltime, 7);
        return $totaltime;
    }

    /*****
     * 计算工作日天数结束日期
     * 吐槽一下，一开始低估了这个算法的复杂性，用了两天时间，真的不容易，写好的算法必须要沉一下心来理清逻辑才能写出来，虽然写得还不是很完美，但在这小佩服一下自己。
     * @param string $startDate 开始日期
     * @param int $days 天数
     * @param string $holidays 法定节假日字符串
     * @param string $workDays 调休上班日字符串
     * @return false|string 到期日期（不含）
     */
    //*2021年法定节日数据:{"holidays":"2021-01-01,2021-01-02,2021-01-03,2021-02-11,2021-02-12,2021-02-13,2021-02-14,2021-02-15,2021-02-16,2021-02-17,2021-04-03,2021-04-04,2021-04-05,2021-05-01,2021-05-02,2021-05-03,2021-05-04,2021-05-05,2021-06-12,2021-06-13,2021-06-14,2021-09-19,2021-09-20,2021-09-21,2021-10-01,2021-10-02,2021-10-03,2021-10-04,2021-10-05,2021-10-06,2021-10-07","workdays":"2021-02-07,2021-02-20,2021-04-25,2021-05-08,2021-09-18,2021-09-26,2021-10-09"}
    static public function getWorkingEndDate($startDate,$days,$holidays,$workDays)
    {
        //开始日期
        $startDate = strtotime($startDate);
        $daysnum=0;
        $num=0;
        //法定节假日数组
        $holiDays=explode(",",$holidays);
        //调休工作日数组
        $workDays=explode(",",$workDays);
        //法定节假日
        $holiday=0;
        //周末
        $weekday=0;
        //调休工作日
        $workday=0;
        //循环daysnum
        while(($daysnum)<intval($days)){
            //临时日期
            $tempdate=$startDate+$num*(60*60*24);
            //周末天数
            if(date("N", $tempdate) == 6 || date("N", $tempdate) == 7)
                $weekday++;
            //周末天数遇到法定节假日减去周末天数
            if(in_array(date('Y-m-d',$tempdate),$holiDays)&&(date("N", $tempdate) == 6 || date("N", $tempdate) == 7))
                $weekday--;
            //法定节假日天数
            if(in_array(date('Y-m-d',$tempdate),$holiDays))
                $holiday++;
            //法定调休工作日
            if(in_array(date('Y-m-d',$tempdate),$workDays))
                $workday++;
            //循环自增
            $num++;
            //天数=循环天数+工作日-节假日-周末
            $daysnum=$num+$workday-$holiday-$weekday;
        }
        //最后计算天数正好与之前计算相反
        //天数=需要的工作日-法定调休工作日+法定节假日+周末天数
        $daysnum=$days-$workday+$holiday+$weekday;
        //返回
        return date("Y-m-d H:i:s",$startDate+$daysnum*(60*60*24));
    }
    /**
     * 计算两日期之间的工作日天数
     * @param string $startDate 开始日期
     * @param string $endDate 结束日期
     * @param string $holidays 法定节假日
     * @param string $workDays 调休上班日
     * @return float|int
     */
    static public function getWorkingDays($startDate, $endDate, $holidays,$workDays)
    {
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);
        $days = ($endDate - $startDate) / 86400 + 1;
        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        } else {
            if ($the_first_day_of_week == 7) {
                $no_remaining_days--;
                if ($the_last_day_of_week == 6) {
                    $no_remaining_days--;
                }
            } else {
                $no_remaining_days -= 2;
            }
        }
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0) {
            $workingDays += $no_remaining_days;
        }
        //法定休息日计算
        $holidays=explode(",",$holidays);
        for($i=0;$i<count($holidays);$i++){
            $time_stamp = strtotime($holidays[$i]);
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
                $workingDays--;
        }
        //调休工作日调整
        $workDays=explode(",",$workDays);
        for($i=0;$i<count($workDays);$i++){
            $time_stamp = strtotime($workDays[$i]);
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && (date("N", $time_stamp) == 6 || date("N", $time_stamp) == 7))
                $workingDays++;
        }
        return $workingDays;
    }

}