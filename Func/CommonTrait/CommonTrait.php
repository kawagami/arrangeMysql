<?php

namespace Func\CommonTrait;

trait CommonTrait
{
    /**
     * 返回特定附檔名給 glob 查詢的字串
     * 
     * @return string
     */
    public static function globPath(): string
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

    /**
     * 返回檔案大小的字串
     * 
     * @return string
     */
    public static function countSize(int $size): string
    {
        $times = 0;
        while (strlen(round($size)) > 3) {
            $times++;
            $size = $size / 1024;
        }

        switch ($times) {
            case 0:
                $sizeEnd = 'bytes';
                break;

            case 1:
                $sizeEnd = 'KB';
                break;

            case 2:
                $sizeEnd = 'MB';
                break;

            case 3:
                $sizeEnd = 'GB';
                break;

            case 4:
                $sizeEnd = 'TB';
                break;

            case 5:
                $sizeEnd = 'PB';
                break;

            default:
                $sizeEnd = 'Too Heavy';
                break;
        }
        return round($size, 2) . ' ' . $sizeEnd;
    }
};
