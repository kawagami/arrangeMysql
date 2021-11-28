<?php

require_once('Mysql.php');
require_once('Video/Video.php');
require_once('Comic/Comic.php');

use Database\Mysql;
use Video\Video;
use Comic\Comic;

// $mysql_address  = '127.0.0.1';
// $mysql_username = 'root';
// $mysql_password = 'root';
// $mysql_database = 'arrange';
// $sql            = new Mysql($mysql_address, $mysql_username, $mysql_password, $mysql_database);


function main()
{
    getComicInfo();
}

function getComicInfo()
{
    $comic = new Comic();
    // var_dump($comic->get());
    foreach ($comic->get() as $key => $value) {
        echo $key;
        echo "\n";
        echo "V";
        echo "\n";
        echo $value;
        echo "\n";
        echo "\n";
    }
}

function getVideoInfo()
{
    $video = new Video();
    var_dump($video->get());
}

function createTable($table = 'storage_places')
{
    $createTable = "CREATE TABLE {$table}(
        id VARCHAR(20),
        Name VARCHAR(20),
        type VARCHAR(20)
    );";
    $sql = new Mysql();
    $sql->rawQuery($createTable);
}

function insertData($table = 'storage_places', $data)
{
    $data = [
        'id'   => uniqid(),
        'name' => '儲存碟1',
        'type' => '外接-sata-HDD',
    ];
    $sql = new Mysql();
    $sql->insert($table, $data);
}

function insertDatas($table = 'storage_places', $datas)
{
    $datas = [
        [
            'id'   => uniqid(),
            'name' => 'C槽',
            'type' => '內接-M2-SSD',
        ],
        [
            'id'   => uniqid(),
            'name' => 'D槽',
            'type' => '內接-M2-SSD',
        ],
        [
            'id'   => uniqid(),
            'name' => '儲存碟1',
            'type' => '外接-sata-HDD',
        ],
    ];
    $sql = new Mysql();
    foreach ($datas as $key => $value) {
        $sql->insert($table, $value);
    }
}

function delete($table = 'storage_places', $id)
{
    $sql = new Mysql();
    $sql->delete($table, 'id', $id);
}

function showTables()
{
    $sql = new Mysql();
    $showTables = 'show tables;';
    var_dump($sql->rawQuery($showTables));
}

function showTableInfo($table = 'storage_places')
{
    $sql = new Mysql();
    $showTableInfo = "select * from {$table};";
    var_dump($sql->rawQuery($showTableInfo));
}

function dropTable($table = 'storage_places')
{
    $sql = new Mysql();
    $dropTable = "drop table {$table};";
    var_dump($sql->rawQuery($dropTable));
}

main();
