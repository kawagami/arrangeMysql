<?php

namespace Comic;

class Comic
{
    public function __construct()
    {
        // 取得作者清單、路徑
        $this->authorDir  = 'D:\comic\H\*';
        $this->authorList = glob($this->authorDir);
        $this->handleArrangedAuthorList();
    }

    private function handleArrangedAuthorList()
    {
        // 取得所有作者名稱、返回
        $pattern = '/\[(.*[^()])\]|\[(.*) ?\((.*)\)/';
        $subjects = $this->authorList;
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
                    'fileSize' => $this->countSize($fileSize),
                ];
            }
            if (count($matches) > 2) {
                $this->arrangedAuthorList[trim($matches[2])] = [
                    'path'      => $subject,
                    'comic'     => $comicDataArray,
                    'totalSize' => $this->countSize($totalSize),
                ];
                $this->arrangedAuthorList[$matches[3]] = [
                    'path'      => $subject,
                    'comic'     => $comicDataArray,
                    'totalSize' => $this->countSize($totalSize),
                ];
            } else {
                $this->arrangedAuthorList[$matches[1]] = [
                    'path'      => $subject,
                    'comic'     => $comicDataArray,
                    'totalSize' => $this->countSize($totalSize),
                ];
            }
        }
    }

    public function get()
    {
        return $this->arrangedAuthorList;
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
