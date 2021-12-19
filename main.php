<?php

require_once('Mysql.php');
require_once('Video/Video.php');
require_once('Comic/Comic.php');
require_once('Func/TempVideo/TempVideo.php');

use Database\Mysql;
use Video\Video;
use Comic\Comic;
use Func\TempVideo\TempVideo;

$storage_places  = 'storage_places';
$comic_authors   = 'comic_authors';
$comic           = 'comic';
$video_actresses = 'video_actresses';
$video           = 'video';

function main()
{
    // $table = 'storage_places';

    // print_r(TempVideo::get());
    // print_r(Video::get());

    $query = processQuery(TempVideo::get());
    rawQuery($query);
    // $data = [
    //     'raw_data'  => 'D:\JULIA-押しの強い爆乳女の熱くねっとり下品なSEX.avi',
    //     'basename'  => 'JULIA-押しの強い爆乳女の熱くねっとり下品なSEX',
    //     'file_type' => 'avi',
    //     'size'      => '978.48 MB',
    //     'log_time'  => time(),
    // ];
    // insertData($data);

    // foreach (getVideoInfo() as $key => $value) {
    //     insert($table, ['name' => $key]);
    //     # code...
    // }

    // showTableInfo($table);
}

/**
 * 丟入多筆資料 array 產出 insert 的 query
 * 
 * @param array $data
 * @return string
 */
function processQuery(array $data, string $table = 'temp_table'): string
{
    $columnName   = [];
    $valueArray   = [];
    foreach ($data as $rowData) {
        $tempValueArray = [];
        foreach ($rowData as $column => $value) {
            if (!in_array("`$column`", $columnName)) {
                $columnName[] = "`$column`"; // 取得欄位名稱
            }
            $value = str_replace('\\', '\\\\', $value); // 沒變換的話在資料庫內單斜線會消失
            $tempValueArray[] = "'$value'"; // 將 value 存入 temp array
        }
        $valueArray[] = '(' . join(',', $tempValueArray) . ')'; // 將 temp array 的 value 用 join 整理成一筆要存入的 value
    }
    $queryColumn = '(' . join(',', $columnName) . ')';
    $queryValue  = join(',', $valueArray) . ';';
    $query       = "INSERT INTO {$table} {$queryColumn} VALUES {$queryValue}";  // 插入資料的 sql 語句
    return $query;
}

/**
 * 一次插入多行資料
 */
function insertMultipleRows()
{
    // example
    // 
    // INSERT INTO
    //     table_name (column_list)
    // VALUES
    //     (value_list_1),
    //     (value_list_2),
    //     ...
    //     (value_list_n);
    $table        = 'temp_table';
    $columnName   = [];
    $valueArray   = [];
    foreach (Video::get() as $v1) {
        foreach ($v1 as $v2) {
            if (is_array($v2)) {
                foreach ($v2 as $v3) {
                    $tempValueArray = [];
                    foreach ($v3 as $key => $value) {
                        if (!in_array("`$key`", $columnName)) {
                            $columnName[] = "`$key`"; // 取得欄位名稱
                        }
                        $value = str_replace('\\', '\\\\', $value); // 沒變換的話在資料庫內單斜線會消失
                        $tempValueArray[] = "'$value'"; // 將 value 存入 temp array
                    }
                    $valueArray[] = '(' . join(',', $tempValueArray) . ')'; // 將 temp array 的 value 用 join 整理成一筆要存入的 value
                }
            }
        }
    }
    $queryColumn = '(' . join(',', $columnName) . ')';
    $queryValue  = join(',', $valueArray) . ';';
    $query       = "INSERT INTO {$table} {$queryColumn} VALUES {$queryValue}";  // 插入資料的 sql 語句
    // rawQuery($query); // 執行 query
}

/**
 * 新增整理過的資料夾內的資料進資料庫
 * 不考慮速度的寫法 很慢
 * 
 * @param array $arrangedData
 */
function insertArrangedData(array $arrangedData)
{
    foreach ($arrangedData as $v1) {
        foreach ($v1 as $v2) {
            if (is_array($v2)) {
                foreach ($v2 as $v3) {
                    insertData($v3);
                    // print_r($v3);
                }
                // print_r($v2);
                # code...
            }
        }
        // echo PHP_EOL;
    }
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
    array $data,
    string $table = 'temp_table'
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
            'name' => 'C槽',
            'type' => '內接-M2-SSD',
        ],
        [
            'name' => 'D槽',
            'type' => '內接-M2-SSD',
        ],
        [
            'name' => '儲存碟1',
            'type' => '外接-sata-HDD',
        ],
    ];
    foreach ($datas as $key => $value) {
        insert($table, $value);
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

// function updateActressesOrAuthors(): void
// {
//     $table = 'video_actresses';
//     foreach ($table === 'comic_authors' ? getComicInfo() : getVideoInfo() as $key => $value) {
//         $cmd = "select 1 from {$table} where name = '{$key}'";
//         if (count(rawQuery($cmd)) !== 0) {
//             continue;
//         }
//         $data = [
//             'id'           => uniqid(),
//             'name'         => $key,
//             'created_time' => nowDate(),
//         ];
//         insertData($table, $data);
//     }
//     showTableInfo($table);
// }

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
