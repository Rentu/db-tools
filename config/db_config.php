<?php
/**
 * Created by PhpStorm.
 * User: Devilu
 * Date: 2018/7/5
 * Time: 14:20
 */
return [
   [
       "host" => "",
       "db" => "",
       "user" => " ",
       "passwd" => " ",
       "method" => "",
       "after" => [
           [
               "table" => "",
               "num" => 100000000
           ]
       ],
       "db_suffix" => "",
       "range" => "",
       "skip" => [
       ],
       "action" => "truncate"
   ],
   [
       "host" => " ",
       "db" => "",
       "user" => " ",
       "passwd" => " ",
       "method" => "traverse", // 遍历清空
       "after" => [
       ],
       "db_suffix" => "", // 数据库后缀
       "range" => [0], //0,1,2,3,4,5,6,7,8,9
       "skip" => [
       ],
       "action" => "truncate"
   ],
   [
       "host" => " ",
       "db" => "",
       "user" => " ",
       "passwd" => " ",
       "method" => "traverse", // 遍历
       "after" => [
       ],
       "rule" => [
           "order" => "desc",
           "str" => "_00",
           "length" => 3,
           "method" => "equal" // include,equal
       ],
       "db_suffix" => "", // 数据库后缀
       "range" => [2,3,4,5,6,7,8,9], //0,1,2,3,4,5,6,7,8,9
       "skip" => [
       ],
       "action" => "dropTable"
   ],
    [
        "host" => " ",
        "db" => "",
        "user" => " ",
        "passwd" => " ",
        "method" => "traverse", // 遍历更改表名
        "after" => [
        ],
        "db_suffix" => "", // 数据库后缀
        "rule" => [
            "length" => 3,
            "order" => "desc",
            "newTable" => "incr",
            "end" => "_",
            "start" => 0
        ],
        "range" => [0], //0,1,2,3,4,5,6,7,8,9
        "skip" => [
            ""
        ],
        "action" => "changeTableName"
    ],
];