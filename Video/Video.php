<?php

namespace Video;

require_once(dirname(__FILE__) . '/../Func/CommonTrait/CommonTrait.php');

class Video
{
    use \Func\CommonTrait\CommonTrait;

    private static $actressPath          = 'D:\video\H\*';
    private static $actressNamePathArray = [];

    /**
     * 這段是『建構式』會在物件被 new 時自動執行
     */
    public function __construct()
    {
        // 
    }

    /**
     * 整理從 glob 取得的資料
     * 
     * @return void
     */
    private static function handleData(): void
    {
        $rawList = glob(static::$actressPath);
        foreach ($rawList as $key => $value) {
            $name           = basename($value);
            $videoArray     = glob("D:\\video\\H\\{$name}\\*");
            $videoDataArray = [];
            $totalSize      = 0;
            foreach ($videoArray as $k => $v) {
                $fileSize   = filesize($v);
                $totalSize += $fileSize;
                $videoDataArray[] = [
                    'filePath' => $v,
                    'fileSize' => static::countSize($fileSize),
                ];
            }
            static::$actressNamePathArray[$name] = [
                'path'      => $value,
                'videos'    => $videoDataArray,
                'totalSize' => static::countSize($totalSize),
            ];
        }
    }

    /**
     * 呼叫整理資料的 method 並回傳整理後的資料
     * 
     * @return array
     */
    public static function get(): array
    {
        static::handleData();
        return static::$actressNamePathArray;
    }

    /**
     * 這段是『解構式』會在物件被 unset 時自動執行
     */
    public function __destruct()
    {
        // mysqli_close($this->link);
    }
}
