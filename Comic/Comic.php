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
            if (count($matches) > 2) {
                $this->arrangedAuthorList[trim($matches[2])] = [
                    'path' => $subject,
                    'comic' => $reSortComicArray,
                ];
                $this->arrangedAuthorList[$matches[3]] = [
                    'path' => $subject,
                    'comic' => $reSortComicArray,
                ];
            } else {
                $this->arrangedAuthorList[$matches[1]] = [
                    'path' => $subject,
                    'comic' => $reSortComicArray,
                ];
            }
        }
    }

    public function get()
    {
        return $this->arrangedAuthorList;
    }
}
