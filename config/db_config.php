<?php
/**
 * Created by PhpStorm.
 * User: Devilu
 * Date: 2018/7/5
 * Time: 14:20
 */

use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$path = realpath(__DIR__."/../.env");
$dotenv->load($path);

return[
    [
        "host" => "",
        "db" => "",
        "user" => "",
        "passwd" => "",
        "range" => [0], //0,1,2,3,4,5,6,7,8,9
    ]
];
