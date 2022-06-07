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
 *  | Date: 2020/10/1 下午5:19
 *  +----------------------------------------------------------------------
 *  | Description:   文件处理类
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;
use SplFileObject;
use ZipArchive;

class FilesHelper
{

    private const DS = '/';
    /****
     * 保存远程文件到本地
     * @param $url
     * @param string $path
     * @return string
     */
    static public function download_file($url, $path = '/Upload/Download/')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        $filename = pathinfo($url, PATHINFO_BASENAME);
        $resource = fopen($path . $filename, 'a');
        fwrite($resource, $file);
        fclose($resource);
        return $path . $filename;
    }

    /****
     * 创建压缩文件
     * @param string|array $zipName 如果有多个文件则为数组，如果是单个文件则为字符串
     * $zipName = array(file1,file2,file3) or $zipName = 'file.text';
     * @param string $files  压缩包名 $zipName = 'test.zip'
     * @return array|string[]
     */
    static public function zip_create($zipName,$files){
        //$files = array('upload/qrcode/1/1.jpg');
        $zip = new ZipArchive;//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
        /*
         * 通过ZipArchive的对象处理zip文件
         * $zip->open这个方法如果对zip文件对象操作成功，$zip->open这个方法会返回TRUE
         * $zip->open这个方法第一个参数表示处理的zip文件名。
         * 这里重点说下第二个参数，它表示处理模式
         * ZipArchive::OVERWRITE 总是以一个新的压缩包开始，此模式下如果已经存在则会被覆盖。
         * ZIPARCHIVE::CREATE 如果不存在则创建一个zip压缩包，若存在系统就会往原来的zip文件里添加内容。
         *
         * 这里不得不说一个大坑。
         * 我的应用场景是需要每次都是创建一个新的压缩包，如果之前存在，则直接覆盖，不要追加
         * so，根据官方文档和参考其他代码，$zip->open的第二个参数我应该用 ZipArchive::OVERWRITE
         * 问题来了，当这个压缩包不存在的时候，会报错：ZipArchive::addFile(): Invalid or uninitialized Zip object
         * 也就是说，通过我的测试发现，ZipArchive::OVERWRITE 不会新建，只有当前存在这个压缩包的时候，它才有效
         * 所以我的解决方案是 $zip->open($zipName, \ZIPARCHIVE::OVERWRITE | \ZIPARCHIVE::CREATE)
         *
         * 以上总结基于我当前的运行环境来说
         * */

        if ($zip->open($zipName, $zip::OVERWRITE | $zip::CREATE)!==TRUE) {
            exit('无法打开文件，或者文件创建失败');
        }
        if(is_array($files)){
            foreach($files as $val){
                //$attachfile = $attachmentDir . $val['filepath']; //获取原始文件路径
                if(file_exists($val)){
                    //addFile函数首个参数如果带有路径，则压缩的文件里包含的是带有路径的文件压缩
                    //若不希望带有路径，则需要该函数的第二个参数
                    $zip->addFile($val, basename($val));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
                }
            }
        }else{
            if(file_exists($files)){
                //addFile函数首个参数如果带有路径，则压缩的文件里包含的是带有路径的文件压缩
                //若不希望带有路径，则需要该函数的第二个参数
                $zip->addFile($files, basename($files));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
            }
        }
        $zip->close();//关闭

        if(!file_exists($zipName)){
            $return = array(
                //	'zipName' => $zipName,
                'status'  => 'ERROR',  //创建失败
            );
            //  $status ="无法找到文件"; //即使创建，仍有可能失败
        }else{
            $return = array(
                'zipName' => $zipName,
                'status'  => "success"
            );
        }
        return $return;

    }

    /*****
     * 提取取文件格式-后缀、文件格式
     * @param string $file 文件名
     * @return string 文件后缀
     */
    static public function get_file_ext($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }

    /****
     * @param string $file 文件名
     * @return mixed|string 只返回文件类型
     */
    static public function get_file_type($file){
        $format = self::file_format($file);
        return $format["file_type"];
    }

    /****
     * 浏览器自动下载文件
     * @param string $filename 保存文件名
     * @param string $format 保存文件格式
     */
    static public function brows_download($filename,$format='zip'){
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename='.basename($filename)); //文件名
        header("Content-Type: application/".$format); //文件格式
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小
        @readfile($filename);
    }

    /**
     * 返回文件格式和类型
     * @param  string $file 文件名
     * @return string|array 文件类型和格式后缀
     */
    static public function file_format($file){
        // 取文件后缀名
        $str= self::get_file_ext($file);
        // 图片格式
        $image=array('webp','jpg','png','ico','bmp','gif','tif','pcx','tga','bmp','pxc','tiff','jpeg','exif','fpx','svg','psd','cdr','pcd','dxf','ufo','eps','ai','hdri');
        // 视频格式
        $video=array('mp4','avi','3gp','rmvb','gif','wmv','mkv','mpg','vob','mov','flv','swf','mp3','ape','wma','aac','mmf','amr','m4a','m4r','ogg','wav','wavpack');
        // 压缩格式
        $zip=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2','tz');
        // 文档格式
        $text=array('exe','doc','ppt','xls','wps','txt','lrc','wfs','torrent','html','htm','java','js','css','less','php','pdf','pps','host','box','docx','word','perfect','dot','dsf','efe','ini','json','lnk','log','msi','ost','pcs','tmp','xlsb');
        // 匹配不同的结果
        switch ($str) {
            case in_array($str, $image):
                $result = [
                    'file_type'=>'image',
                    'file_ext' =>$str,
                ];
                break;
            case in_array($str, $video):
                $result = [
                    'file_type'=>'video',
                    'file_ext' =>$str,
                ];
                break;
            case in_array($str, $zip):
                $result = [
                    'file_type'=>'zip',
                    'file_ext' =>$str,
                ];
                break;
            case in_array($str, $text):
                $result = [
                    'file_type'=>'text',
                    'file_ext' =>$str,
                ];
                break;
            default:
                $result = [
                    'file_type'=>'files',
                    'file_ext' =>$str,
                ];
                break;
        }
        return $result;
    }

    /****
     * 以只读方式打开文件
     * @param string $file_name  filename
     * @param string $type string|字符串方式打开 array|数组方式打开
     * @return array|false|string
     */
    static public function open_files($file_name='',$type = 'string'){
        if(file_exists($file_name)){
            switch ($type){
                case 'array' :
                    return file($file_name);
                    break;
                default :
                    return file_get_contents($file_name);
                    break;
            }
        }
        return false;
    }

    /**
     * 遍历指定目录及子目录下的文件，返回所有与匹配模式符合的文件名
     *
     * @param string $dir
     * @param string $pattern
     *
     * @return array
     */
    static function dir_files_list($dir, $pattern="*")
    {
        $pattern = ($pattern == "*") ? $pattern : "*" . $pattern;
        $dir = rtrim($dir, '/\\') . self::DS;
        $files = array();

        // 遍历目录，返回所有文件和子目录
        $dh = opendir($dir);
        if (!$dh) return $files;

        $items = (array)glob($dir . $pattern);
        foreach ($items as $item)
        {
            if (is_file($item)) $files[] = $item;
        }

        while (($file = readdir($dh)))
        {
            if ($file == '.' || $file == '..') continue;

            $path = $dir . $file;
            if (is_dir($path))
            {
                $files = array_merge($files, self::dir_files_list($path, $pattern));
            }
        }
        closedir($dh);

        return $files;
    }


    /**
     * 删除超过指定时间内的文件内容
     * @param string $path 文件目录
     * @param int $time 指定时间前 单位（h），默认24小时
     * @return array
     * del_file('d:/www');
     */
    static public function del_file($path , $time=24) {
        $current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
        $result = [];
        while(($file = readdir($current_dir)) !== false) {    //readdir()返回打开目录句柄中的一个条目
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
            if($file == '.' || $file == '..') {
                continue;
            } else if(is_dir($sub_dir)) {    //如果是目录,进行递归
                self::del_file($sub_dir);
            } else {    //如果是文件,判断是24小时以前的文件进行删除
                $files = fopen($path.self::DS.$file,"r");
                $f =fstat($files);
                fclose($files);
                if($f['mtime']<(time()-3600*$time)){
                    if (@unlink($path . self::DS . $file)) {
                        $data = wrap_msg_array('1', '删除成功', ['file' => $path . '/' . $file, 'status' => 'success']);
                        array_push($result, $data);
                    } else {
                        $data = wrap_msg_array('0', '删除失败', ['file' => $path . '/' . $file, 'status' => 'error']);
                        array_push($result, $data);
                    }
                }
            }
        }
        return $result;
    }


    /****
     * 检查打开的文件是否有BOM
     * @param string $filename
     * @return bool
     */
    static public function checkBOM($filename)
    {
        if (!file_exists($filename)) {
            return FALSE;
        }
        $contents   = file_get_contents($filename);
        $charset[1] = substr($contents, 0, 1);
        $charset[2] = substr($contents, 1, 1);
        $charset[3] = substr($contents, 2, 1);
        if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
            return TRUE;
        }
        return FALSE;
    }

    /****
     * 检测目录是否存在
     * 不存在则创建
     * @param $dirname
     * @return bool
     */
    static public function mkdir($dirname){
        $dirname = str_replace('.','_',$dirname);
        if(!is_dir($dirname)){
            return mkdir($dirname,0777,true);
        }
        if (!is_writable($dirname)) {
            return @chmod($dirname, 0777 & ~umask());
        }
    }

    /*****
     * @param string|SplFileObject $file 完整文件路径
     * @return false|SplFileObject
     */
    public static function get_file_info($file){
        if($file instanceof SplFileObject){
            return $file;
        }elseif(is_string($file)){

            return new SplFileObject($file);
        }else{
            return false;
        }
    }





}