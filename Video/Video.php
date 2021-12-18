<?php

namespace Video;

require_once(dirname(__FILE__) . '/../Func/CommonTrait/CommonTrait.php');

class Video
{
    use \Func\CommonTrait\CommonTrait;

    private $actressPath          = 'D:\video\H\*';
    private $actressNamePathArray = [];

    /**
     * 這段是『建構式』會在物件被 new 時自動執行
     */
    public function __construct()
    {
        $rawList = glob($this->actressPath);
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
            $this->actressNamePathArray[$name] = [
                'path'      => $value,
                'videos'    => $videoDataArray,
                'totalSize' => static::countSize($totalSize),
            ];
        }
    }

    public function get()
    {
        return $this->actressNamePathArray;
    }

    /**
     * 這段是『解構式』會在物件被 unset 時自動執行
     */
    public function __destruct()
    {
        // mysqli_close($this->link);
    }
}
