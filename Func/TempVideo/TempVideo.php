<?php

namespace Func\TempVideo;

require_once(dirname(__FILE__) . '/../CommonTrait/CommonTrait.php');

class TempVideo
{
    use \Func\CommonTrait\CommonTrait;

    private static $instance;
    private static $result;

    /**
     * 這段是『建構式』會在物件被 new 時自動執行
     */
    public function __construct()
    {
        // foreach ($rawList as $key => $value) {
        //     $name           = basename($value);
        //     $videoArray     = glob("D:\\video\\H\\{$name}\\*");
        //     $videoDataArray = [];
        //     $totalSize      = 0;
        //     foreach ($videoArray as $k => $v) {
        //         $fileSize   = filesize($v);
        //         $totalSize += $fileSize;
        //         $videoDataArray[] = [
        //             'filePath' => $v,
        //             'fileSize' => $this->countSize($fileSize),
        //         ];
        //     }
        //     $this->actressNamePathArray[$name] = [
        //         'path'      => $value,
        //         'videos'    => $videoDataArray,
        //         'totalSize' => $this->countSize($totalSize),
        //     ];
        // }
    }

    /**
     * 呼叫整理資料的 method 並回傳整理後的資料
     * 
     * @return array
     */
    public static function get(): array
    {
        static::handleData();
        return static::$result;
    }

    /**
     * 整理從 glob 取得的資料
     * 
     * @return void
     */
    public static function handleData(): void
    {
        $result = [];
        foreach (glob(static::globPath(), GLOB_BRACE) as $key => $value) {
            $fileName = explode('.', basename($value));
            $fileSize = static::countSize(filesize($value));
            $result[] = [
                'raw_data'  => $value,
                'basename'  => $fileName[0],
                'file_type' => $fileName[1],
                'size'      => $fileSize,
                'log_time'  => time(),
            ];
        }
        static::$result = $result;
    }

    /**
     * 用靜態方法取得這個 class 的 instance
     * 
     * @return TempVideo
     */
    public static function getInstance(): TempVideo
    {

        if (!isset(self::$instance)) {
            self::$instance = new TempVideo();
        }

        return self::$instance;
    }

    /**
     * 這段是『解構式』會在物件被 unset 時自動執行
     */
    public function __destruct()
    {
        // mysqli_close($this->link);
    }
}
