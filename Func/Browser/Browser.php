<?php

namespace Browser\Browser;

class Browser
{
    public function open()
    {
        // $path = "http://www.wnacg.org/search/?q=123&f=_all&s=create_time_DESC";
        $path = "https://nhentai.net/search/?q=-yaoi+chinese";
        pclose(popen("MicrosoftEdge -url {$path}", 'r'));
    }
}
