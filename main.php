<?php

require_once('Mysql.php');
require_once('Video/Video.php');
require_once('Comic/Comic.php');

use Database\Mysql;
use Video\Video;
use Comic\Comic;

$storage_places  = 'storage_places';
$comic_authors   = 'comic_authors';
$comic           = 'comic';
$video_actresses = 'video_actresses';
$video           = 'video';

function main()
{
    // $table = 'video';

    // getVideoInfo();
    // getComicInfo();
    // print_r(getVideoInfo());
    print_r(getComicInfo());

    // foreach (getVideoInfo() as $key => $value) {
    //     insert($table, ['name' => $key]);
    //     # code...
    // }

    // showTableInfo($table);
}

function getComicInfo(): array
{
    $comic = new Comic();
    return $comic->get();
}

function getVideoInfo(): array
{
    $video = new Video();
    return $video->get();
}

function createTable($table = 'storage_places')
{
    $createTable = "CREATE TABLE {$table}(
        id VARCHAR(20),
        name VARCHAR(20) unique,
        created_time DATE
    );";
    $sql = new Mysql();
    $sql->rawQuery($createTable);
}

function insertData(
    string $table = 'storage_places',
    array $data
) {
    // $data = [
    //     'id'   => uniqid(),
    //     'name' => '儲存碟1',
    //     'type' => '外接-sata-HDD',
    // ];
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

function rawQuery($cmd)
{
    if ($cmd === null) {
        return false;
    }
    $sql = new Mysql();
    return $sql->rawQuery($cmd);
}

function nowDate(): string
{
    date_default_timezone_set("Asia/Taipei");
    return date('Y-m-d H:i:s');
}

function updateActressesOrAuthors(): void
{
    $table = 'video_actresses';
    foreach ($table === 'comic_authors' ? getComicInfo() : getVideoInfo() as $key => $value) {
        $cmd = "select 1 from {$table} where name = '{$key}'";
        if (count(rawQuery($cmd)) !== 0) {
            continue;
        }
        $data = [
            'id'           => uniqid(),
            'name'         => $key,
            'created_time' => nowDate(),
        ];
        insertData($table, $data);
    }
    showTableInfo($table);
}

function insert($table, $data)
{
    switch ($table) {
        case 'storage_places':
            insertStoragePlaces($table, $data);
            break;

        case 'comic_authors':
            insertComicAuthors($table, $data);
            break;

        case 'comic':
            insertComic($table, $data);
            break;

        case 'video_actresses':
            insertVideoActresses($table, $data);
            break;

        case 'video':
            insertVideo($table, $data);
            break;

        default:
            # code...
            break;
    }
}

/**
 * @var $data['name'] required
 * @var $data['type'] required
 * 
 */
function insertStoragePlaces(string $table, array $data)
{
    $data['id'] = uniqid();
    $sql = new Mysql();
    $sql->insert($table, $data);
}

/**
 * @var $data['name'] required
 * 
 */
function insertComicAuthors(string $table, array $data)
{
    $data['id'] = uniqid();
    $sql = new Mysql();
    $sql->insert($table, $data);
}

/**
 * @var $data['author_id'] required
 * @var $data['place_id'] required
 * @var $data['name'] required
 * 
 */
function insertComic(string $table, array $data)
{
    $data['id'] = uniqid();
    $sql = new Mysql();
    $sql->insert($table, $data);
}

/**
 * @var $data['name'] required
 * 
 */
function insertVideoActresses(string $table, array $data)
{
    $data['id'] = uniqid();
    $sql = new Mysql();
    $sql->insert($table, $data);
}

/**
 * @var $data['actress_id'] required
 * @var $data['place_id'] required
 * @var $data['name'] required
 * 
 */
function insertVideo(string $table, array $data)
{
    $data['id'] = uniqid();
    $sql = new Mysql();
    $sql->insert($table, $data);
}


main();
