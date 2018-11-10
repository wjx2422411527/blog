<?php
namespace models;
use PDO;
class Regist{
    public function regist($post){
        //    主机  ip        数据库名          用户名   密码
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=jxshops','root','123456');
        // 设置编码
        $pdo->exec('SET NAMES utf8');
        // query只能查    执行一条sql语句   只能执行  select  返回值 是一个对象
        $user = $post['user'];
        $pwd = md5($post['pwd']);
        $stmt = $pdo->query("select * from users where user = '$user'");
        // var_dump($stmt);
        // fetchAll是查询 多条记录 返回的是一个二维数组
            // fetch 是查询  一条记录  返回一个一维 数组
        $a = $stmt->fetch(PDO::FETCH_ASSOC);
        // echo '<pre>';
        // var_dump($a);die;
        //  查询出来的数据  等于 要输入的值一样那就提示登录
        if($a['user'] == $post['user'] ){
            // 要是相等就提示
            echo('账号已经存在请登陆');
        }else{
            // 用户密码插入数据库 
            $res = $pdo->exec("INSERT INTO users(user,password) VALUES('{$user}','{$pwd}')");
            // var_dump($res);die;
            if($res){
                echo '注册成功';
            }else{
                echo '注册失败';
            }
        }
    }
}