<?php
function compressComicAndDeleteDirectory($path)
{
    if (!is_dir($path)) {
        echo "{$path}";
        echo "\n";
        echo "不是資料夾";
        echo "\n";
        echo "\n";
        return false;
    } else {
        // Get real path for our folder
        $rootPath          = $path;
        $absoluteDirectory = str_replace(basename($path), '', $rootPath);
        $fileName          = $absoluteDirectory . basename($path) . '.zip';

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();
        echo basename($path) . ' Compress Done !';
        echo "\n";
        delete($path);
        // removeFiles($path);
    }
}

function removeFiles($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK);
        foreach ($files as $file) {
            removeFiles($file);
        }
        rmdir($target);
    } elseif (is_file($target)) {
        unlink($target);
    }
}

function delete($path)
{
    if (!is_dir($path)) {
        return false;
    } else {
        // $dir = 'samples' . DIRECTORY_SEPARATOR . 'sampledirtree';
        $it    = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                echo "Delete {$path} DIRECTORY";
                echo "\n";
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        if (is_dir($path)) {
            rmdir($path);
        }
    }
}

foreach (glob('D:\temp\*') as $key => $value) {
    compressComicAndDeleteDirectory($value);
}
