<?php
/**
 * Created by PhpStorm.
 * User: Devilu
 * Date: 2018/7/27
 * Time: 14:29
 */
namespace src;

interface DbLogicInterface{

    // 获取每个数据库连接句柄
    public function getEachDbHandle($db_config);

}