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
        $dsn = "mysql:dbname=".self::$_config['db'].";host=".self::$_config['host'];
        $dbh = new PDO($dsn, self::$_config["user"], self::$_config["passwd"]);
        $this->_dbh = $dbh;
    }

    /**
     * @param $table
     * @return mixed
     */
    public function truncate($table)
    {
        $sql = "truncate table {$table}";
        echo $sql."\n";
        return $this->_dbh->exec($sql);
    }

    /**
     * @return Array
     */
    public function getTables() : Array
    {
        $sql = "show tables";
        echo $sql."\n";
        $query =  $this->_dbh->query($sql);
        return $query->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * 设置自增值
     * @param $table
     * @param $num
     * @return mixed
     */
    public function setAutoIncrementAfter($table, $num)
    {
        $sql = "alter table {$table} auto_increment={$num}";
        echo $sql."\n";
        return $this->_dbh->exec($sql);
    }

    /**
     * 修改表名
     * @param $oldName
     * @param $newName
     * @return mixed
     */
    public function changeTableName($oldName, $newName){
        $sql = "alter table {$oldName} rename {$newName}";
        echo $sql."\n";
        return $this->_dbh->exec($sql);
    }

    /**
     * @param $table
     * @return mixed
     */
    public function droptable($table){
        $sql = "drop table $table";
        echo $sql."\n";
        return $this->_dbh->exec($sql);
    }

    public function dropIndex(){

    }

    public function addIndex(){

    }





}