#!/bin/sh

#进程名称
process_name=run.php

while [ 0 -eq 0 ]
do
    ps -ef|grep $process_name |grep -v grep
    # $? -ne 0 不存在，$? -eq 0 存在
    if [ $? -ne 0 ]
    then
    echo ">>>进程已停止，正在启动\n"
    #启动进程
    nohup php $process_name &
    
    break
    else
    echo ">>>进程正在运行，正在停止\n"
    #停止进程
    ps -ef | grep $process_name | grep -v grep | awk '{print $2}' | xargs kill
    #休眠一秒后判断
    sleep 1
    fi
done