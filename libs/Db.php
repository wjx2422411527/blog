<?php
namespace libs;
use PDO;
class Db{
  
    public $db = null;
    public $name = null;
    private static $pdo = null;
    // 
  
    private function __clone(){
        echo "2";
    }
    //单例模式
    private function __construct(){
      
        $this->db = new PDO('mysql:host=127.0.0.1;dbname=jxshops','root','123456');
        $this->db->exec('SET NAMES utf8');
    }
 
    public static function make(){
        
        if(self::$pdo===null){

            self::$pdo = new self; 
        }

        return self::$pdo;
        
    }

}

