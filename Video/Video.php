<?php

namespace Video;

class Video
{
    private $actressPath          = 'D:\video\H\*';
    private $actressNamePathArray = [];

    /**
     * 這段是『建構式』會在物件被 new 時自動執行
     */
    public function __construct()
    {
        $rawList = glob($this->actressPath);
        foreach ($rawList as $key => $value) {
            $name = basename($value);
            $this->actressNamePathArray[$name] = [
                'path'   => $value,
                'videos' => glob("D:\\video\\H\\{$name}\\*"),
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
