<?php

namespace Func\TempVideo;

class TempVideo
{
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

    public static function get(): array
    {
        static::handleData();
        return static::$result;
    }

    public static function handleData(): void
    {
        $result = [];
        foreach (glob(static::globPath(), GLOB_BRACE) as $key => $value) {
            $fileName = explode('.', basename($value));
            $fileSize = static::countSize(filesize($value));
            $result[] = [
                'path'     => $value,
                'fileName' => $fileName[0],
                'fileSize' => $fileSize,
            ];
        }
        static::$result = $result;
    }

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

    private static function globPath()
    {
        $types = [
            'mp4',
            'wmv',
            'avi',
        ];
        $path = 'D:\\{';
        foreach ($types as $key => $value) {
            if ($key === 0) {
                $path .= '*.' . $value;
            } else {
                $path .= ',*.' . $value;
            }
        }
        $path .= '}';
        return $path;
    }

    public static function countSize($size, $times = 0)
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
