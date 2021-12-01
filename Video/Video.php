<?php

namespace Video;

class Video
{
    private $actressPath          = 'D:\video\H\*';
    private $actressNamePathArray = [];
    private $endTimes             = 0;

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
                    'fileSize' => $this->countSize($fileSize),
                ];
            }
            $this->actressNamePathArray[$name] = [
                'path'      => $value,
                'videos'    => $videoDataArray,
                'totalSize' => $this->countSize($totalSize),
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

    public function countSize($size, $times = 0)
    {
        while (strlen(round($size)) > 3) {
            $times++;
            $size = $size / 1024;
        }

        switch ($times) {
            case 0:
                $sizeEnd = ' bytes';
                break;

            case 1:
                $sizeEnd = ' KB';
                break;

            case 2:
                $sizeEnd = ' MB';
                break;

            case 3:
                $sizeEnd = ' GB';
                break;

            case 4:
                $sizeEnd = ' TB';
                break;

            case 5:
                $sizeEnd = ' PB';
                break;

            default:
                $sizeEnd = ' Too Heavy';
                break;
        }
        return round($size, 2) . $sizeEnd;
    }
}
