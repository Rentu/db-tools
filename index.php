<?php

require __DIR__."/vendor/autoload.php";
$db_config = require __DIR__."/config/db_config.php";

use src\Connection;

set_time_limit(0);
ini_set('memory_limit', '512M');

echo '<pre>';

foreach ($db_config as $k => $v){
    $shardDbArr = [];
    switch ($v["method"]){
        case "traverse":
            foreach ($v["range"] as $range){
                $db = $v["db"].$v["db_suffix"].$range;
                $newDbData = $v;
                $newDbData["db"] = $db;
                $shardDbArr[] = $newDbData;
            }
            break;
        default:
            $shardDbArr[] = $v;
            break;
    }
    switch ($v["action"]){
        case "truncate": // 清空
            truncate($shardDbArr);
            break;
        case "changeTableName": // 改名
            changeTableName($shardDbArr);
            break;
        case "dropTable": // 删表
            dropTable($shardDbArr);
            break;
    }

}
/**
 * 批量清空表
 * @param array $shardDbArr
 */
function truncate(Array $shardDbArr){
    foreach ($shardDbArr as $shardDb) {
        $dbh  = new Connection($shardDb);
        $tables = $dbh->getTables();
        foreach ($tables as $table){
            if(in_array($table, $shardDb["skip"])){
                continue;
            }
            $dbh->truncate($table);
            if(!empty($shardDb["after"])){
                $afters = $shardDb["after"];
                foreach ($afters as $after) {
                    if($after["table"] == $table){
                        $dbh->setAutoIncrementAfter($after["table"], $after['num']);
                    }
                }
            }
        }
    }
}

/**
 * 批量删表
 * @param array
 */
function dropTable(Array $shardDbArr){
    foreach ($shardDbArr as $shardDb) {
        $dbh = new Connection($shardDb);
        $tables = $dbh->getTables();
        foreach ($tables as $table) {
            if (in_array($table, $shardDb["skip"])) {
                continue;
            }
            $rule = $shardDb["rule"];
            if($rule["order"] == "desc"){
                switch ($rule["method"] == 'equal'){
                    case "equal":
                        $str = substr($table, -$rule["length"]);
                        if($str == $rule["str"]){
                            $dbh->droptable($table);
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
}


/**
 * 批量更换表名
 * @param array
 */
function changeTableName(Array $shardDbArr){
    foreach ($shardDbArr as $shardDb) {
        $dbh = new Connection($shardDb);
        $tables = $dbh->getTables();
        foreach ($tables as $k =>$table) {
            if (in_array($table, $shardDb["skip"])) {
                continue;
            }
            $rule = $shardDb["rule"];
            if($rule["order"] == "desc"){
                $end = substr($table, -$rule["length"], $rule["length"]-($rule["length"]-1));
                if($end == $rule["end"]){
                    $baseTable = substr($table, 0, -$rule["length"]);
                    if($rule["newTable"] == "incr"){
                        $suffix = substr($k, -1);
                        $newTableName = $baseTable.$suffix;
                        $dbh->changeTableName($table, $newTableName);
                    }
                }
            }
        }
    }
}
