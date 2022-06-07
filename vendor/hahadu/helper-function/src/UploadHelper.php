<?php


namespace Hahadu\Helper;
use Hahadu\Helper\FilesHelper;
use SplFileObject;

/****
 * 处理文件上传
 * Class UploadHelper
 * @package Hahadu\Helper
 */
class UploadHelper
{
    /****
     * @var string 上传文件的表单名
     */
    protected static $upFiles = 'files';
    /****
     * @var string 文件保存目录
     */
    protected static $directory = './';
    /****
     * @var SplFileObject 文件对象
     */
    protected static $files;

    /*****
     * UploadHelper constructor.
     * @param string $Files
     */
    public function __construct($Files = ''){
        if(null != $Files) static::$upFiles = $Files;
        $files = $_FILES[static::$upFiles];
        if (!is_dir(static::$directory)) {
            FilesHelper::mkdir(static::$directory);
        } elseif (!is_writable(static::$directory)) {
            @chmod(static::$directory, 0777 & ~umask());
        }

        $uploadFile = static::$directory.basename($files['name']);
        move_uploaded_file($files['tmp_name'], $uploadFile);
        static::$files = FilesHelper::get_file_info($uploadFile);
    }

    /****
     * 文件上传
     * @param string $Files
     * @param null $directory
     * @return string
     */
    public static function uploader($Files = '',$directory = './'){
        if(null!=$directory){
            static::$directory = $directory;
        }
        new static($Files);
        return static::$files->getPathname();
    }

    /****
     * @param string $filename
     * @return SplFileObject|null
     */
    public static function get_file_info($filename=''){
        if(null != $filename){
            static::$files = $filename;
        }
        return FilesHelper::get_file_info(static::$files);
    }

    /****
     * 封装base64提交的文件信息，方便文件上传方法处理
     * @param string $base64Data base64文件数据
     * @param string $format 缓存的文件格式
     * @return SplFileObject
     */
    static public function base64_file_info($base64Data,$format='png'){
        $img = base64_decode($base64Data);
        $cache_name = time().rand_number().'.'.$format;

        $cache_path = static::$directory.$cache_name;
        file_put_contents($cache_path,$img);

        return self::get_file_info($cache_path);

    }


}