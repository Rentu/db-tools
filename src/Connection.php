<?php
/**
 * Created by PhpStorm.
 * User: Devilu
 * Date: 2018/7/5
 * Time: 14:27
 */
namespace src;
use PDO;

class Connection implements ConnectionInterface
{
    static private $_config = null;
    public $_dbh = null;

    public function __construct(array $config)
    {
        self::$_config = $config;
        $this->connection();
    }

    public function connection(){
        try{
            $dsn = "mysql:dbname=".self::$_config['db'].";host=".self::$_config['host'];
            $dbh = new PDO($dsn, self::$_config["user"], self::$_config["passwd"]);
            $this->_dbh = $dbh;
        }catch (\PDOException $e){
            throw $e;
        }
    }

    /**
     * @param $table
     * @return mixed
     */
    public function truncate($dbName, $table)
    {
        try{
            $sql = "truncate table {$table}";
            file_put_contents(getenv('LOG_PAth'), "数据库：{$dbName}  执行Sql: ".$sql."\n", 8);
            return $this->_dbh->exec($sql);
        }catch (\PDOException $e){
            throw $e;
        }

    }

    /**
     * @param $dbName
     * @return \Generator
     */
    public function getTables($dbName)
    {
        try{
            $sql = "show tables";
            file_put_contents(getenv('LOG_PAth'), "数据库：{$dbName}  执行Sql: ".$sql."\n", 8);
            $query =  $this->_dbh->query($sql);
            $tables = $query->fetchAll(PDO::FETCH_COLUMN, 0);
            foreach ($tables as $table){
                yield $table;
            }
        }catch (\PDOException $e){
            throw $e;
        }

    }

    /**
     * 设置自增值
     * @param $table
     * @param $num
     * @return mixed
     */
    public function setAutoIncrementAfter($table, $num)
    {
        try{
            $sql = "alter table {$table} auto_increment={$num}";
            echo $sql."\n";
            return $this->_dbh->exec($sql);
        }catch (\PDOException $e){
            throw $e;
        }

    }







}