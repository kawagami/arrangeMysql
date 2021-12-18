<?php

namespace Comic;

require_once(dirname(__FILE__) . '/../Func/CommonTrait/CommonTrait.php');

class Comic
{
    use \Func\CommonTrait\CommonTrait;

    private static $authorDir          = 'D:\comic\H\*';
    private static $arrangedAuthorList = [];

    public function __construct()
    {
        // 
    }

    private static function handleArrangedAuthorList()
    {
        // 取得所有作者名稱、返回
        $pattern = '/\[(.*[^()])\]|\[(.*) ?\((.*)\)/';
        $subjects = glob(static::$authorDir);
        foreach ($subjects as $subject) {
            preg_match($pattern, $subject, $matches);
            // 使用 scandir 函數取得有日文名稱的資料夾內的資料結構
            $comicArray = scandir($subject);
            // 刪掉 scandir 函數多出來的 . & .. 資料
            if (($key = array_search('.', $comicArray)) !== false) {
                unset($comicArray[$key]);
            }
            if (($key = array_search('..', $comicArray)) !== false) {
                unset($comicArray[$key]);
            }
            // 重新排列從 0 開始的 array
            $reSortComicArray = [];
            foreach ($comicArray as $key => $value) {
                $reSortComicArray[] = $value;
            }
            $comicDataArray = [];
            $totalSize = 0;
            foreach ($reSortComicArray as $k => $v) {
                $fileTotalPath = $subject . DIRECTORY_SEPARATOR . $v;
                $fileSize = filesize($fileTotalPath);
                // $fileSize = 0;
                $totalSize += $fileSize;
                $comicDataArray[] = [
                    'filePath' => $fileTotalPath,
                    'fileSize' => static::countSize($fileSize),
                ];
            }
            if (count($matches) > 2) {
                static::$arrangedAuthorList[trim($matches[2])] = [
                    'path'      => $subject,
                    'comic'     => $comicDataArray,
                    'totalSize' => static::countSize($totalSize),
                ];
                static::$arrangedAuthorList[$matches[3]] = [
                    'path'      => $subject,
                    'comic'     => $comicDataArray,
                    'totalSize' => static::countSize($totalSize),
                ];
            } else {
                static::$arrangedAuthorList[$matches[1]] = [
                    'path'      => $subject,
                    'comic'     => $comicDataArray,
                    'totalSize' => static::countSize($totalSize),
                ];
            }
        }
    }

    /**
     * 呼叫整理資料的 method 並回傳整理後的資料
     * 
     * @return array
     */
    public static function get(): array
    {
        static::handleArrangedAuthorList();
        return static::$arrangedAuthorList;
    }
}
