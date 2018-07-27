<?php
/**
 * Created by PhpStorm.
 * User: Devilu
 * Date: 2018/7/27
 * Time: 14:22
 */
require __DIR__."/vendor/autoload.php";
$db_config = require __DIR__."/config/db_config.php";
set_time_limit(0);

use src\Connection;
use src\DbLogic;

try{
    $filePath = getenv('LOG_PAth');
    if(!file_exists($filePath) || !is_readable($filePath ) || !is_writable($filePath)){
        throw new Exception("文件不存在或者不可读写");
    }
    file_put_contents(getenv('LOG_PAth'), null);
    $dbLogic = new DbLogic();
    $dbList = $dbLogic->getEachDbHandle($db_config);
    foreach ($dbList as $dbName => $dbh){
        // 获取表
        $tables = $dbh->getTables($dbName);
        // 执行truncate
        foreach ($tables as $table){
            $dbh->truncate($dbName, $table);
        }
    }
    // 底下打印，可以去掉
    $logInfo = file_get_contents($filePath);
    dump($logInfo);
}catch (Exception $e){
    dump("错误信息：".$e->getMessage());
    exit;
}