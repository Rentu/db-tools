<?php

namespace src;

use src\Connection;

class DbLogic implements DbLogicInterface{

    /**
     * @param $db_configs
     * @return \Generator
     */
    public function getEachDbHandle($db_configs)
    {
        $list = [];
        $dbList = array_map(function($arr) use ($list){
            $dbName = $arr["db"];
            foreach ($arr['range'] as $k => $number){
                $newDbName = $dbName.$number;
                $arr["db"] = $newDbName;
                $list[$newDbName] = $arr;
            }
            return $list;
        }, $db_configs);
        foreach ( end($dbList) as $k => $dbConfig) {
            $dbh  = new Connection($dbConfig);
            yield $k => $dbh;
        }

    }

}
