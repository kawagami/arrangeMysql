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
        // var_dump($this->arrangedAuthorList);
    }

    private function handleArrangedAuthorList()
    {
        // 取得所有作者名稱、返回
        $pattern = '/\[(.*[^()])\]|\[(.*) ?\((.*)\)/';
        $subjects = $this->authorList;
        foreach ($subjects as $subject) {
            preg_match($pattern, $subject, $matches);
            if (count($matches) > 2) {
                $this->arrangedAuthorList[trim($matches[2])] = $subject;
                $this->arrangedAuthorList[$matches[3]] = $subject;
            } else {
                $this->arrangedAuthorList[$matches[1]] = $subject;
            }
        }
    }

    public function get()
    {
        return $this->arrangedAuthorList;
    }
}
