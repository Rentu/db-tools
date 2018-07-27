<?php
/**
 * Created by PhpStorm.
 * User: Devilu
 * Date: 2018/7/5
 * Time: 14:32
 */

namespace src;

/**
 * 可以按照这个接口标准去创建其他数据库的实例
 * Interface ConnectionInterface
 * @package src
 */
interface ConnectionInterface
{
    public function connection(); // 连接
    public function truncate($dbName, $table); // 清表
    public function getTables($dbName); // 获取表列表
    public function setAutoIncrementAfter($table, $num); // 修改自增值

}