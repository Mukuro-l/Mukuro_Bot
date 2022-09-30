#!/usr/bin/python3
#coding=utf-8
import re
import os
import subprocess
#import pyyaml

#这是一个Mukuro_Bot配置辅助生成程序
print("你好，欢迎使用Mukuro_Bot开发框架")
print("------------------------------")
print("1.该框架并不会窃取你的个人信息")
print("2.绝不会窃取个人账号信息")
print("3.你使用本程序即代表着同意开源协议")
print("------------------------------")
select = input("是否继续？请选择(y|n):")
while True:
    if select == "y":
        the_ad = subprocess.getoutput("uname -m")
        file_path = os.path.dirname(os.path.realpath(__file__))
        if the_ad == "aarch64" or the_ad == "x86_64":
            if the_ad == "aarch64":
                the_ad = "arm64"
            if the_ad == "x86_64":
                the_ad = "amd64"
            print("检测到系统为linux "+the_ad)
            print("正在下载对应版本的go-cqhttp")
            subprocess.getoutput("sudo wget https://cdn.githubjs.cf/Mrs4s/go-cqhttp/releases/download/v1.0.0-rc3/go-cqhttp_linux_"+the_ad+".tar.gz")
            print("已成功下载")
            subprocess.getoutput("sudo mkdir "+str(os.path.dirname(file_path))+"/gocq/")
            print("在上级文件夹创建目录：gocq")
            subprocess.getoutput("sudo mv go-cqhttp_linux_arm64.tar.gz "+str(os.path.dirname(file_path))+"/gocq/")
            subprocess.getoutput("cd "+str(os.path.dirname(file_path))+"/gocq/ && sudo tar -xzf go-cqhttp_linux_"+the_ad+".tar.gz && sudo rm go-cqhttp_linux_"+the_ad+".tar.gz")
            print("已成功下载并解压go-cqhttp")
            print("go-cqhttp所在文件夹："+str(os.path.dirname(file_path))+"/gocq/")
            QQ = input("请输入你的机器人账号：")
            data = re.search(r"[0-9]+",QQ,re.M|re.I)
            if data != None:
                password = input("请输入密码：")
                
                user_exit = input("输入exit退出:")
            else:
                print("error:账号匹配出错！")
                break
            if user_exit == "exit":
                break


