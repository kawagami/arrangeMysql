<?php

namespace ClipBoard\ClipBoard;

class ClipBoard
{
    public function get(): string
    {
        if (PHP_OS_FAMILY === "Windows") {
            // works on windows 7 + (PowerShell v2 + )
            // TODO: is it -1 or -2 bytes? i think it was -2 on win7 and -1 on win10?
            return substr(shell_exec('powershell -sta "add-type -as System.Windows.Forms; [windows.forms.clipboard]::GetText()"'), 0, -1);
        } elseif (PHP_OS_FAMILY === "Linux") {
            // untested! but should work on X.org-based linux GUI's
            return substr(shell_exec('xclip -out -selection primary'), 0, -1);
        } elseif (PHP_OS_FAMILY === "Darwin") {
            // untested! 
            return substr(shell_exec('pbpaste'), 0, -1);
        } else {
            throw new \Exception("running on unsupported OS: " . PHP_OS_FAMILY . " - only Windows, Linux, and MacOS supported.");
        }
    }
}



// echo getClipboard();
// echo "\n";
