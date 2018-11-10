<?php
namespace models;
use PDO;
class Login{
    public function login($post){
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=jxshops','root','123456');
    $pdo->exec('SET NAMES utf8'); 
    // 接受表单
    $user = $post['user'];
    $pwd = md5($post['pwd']);
    // 查询数据库
    $stmt = $pdo->query("SELECT * FROM users WHERE user = '$user' AND password = '$pwd'");
    
    // var_dump($stmt);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);




    // $stmt = $pdo->query("SELECT * FROM users WHERE user = '$user' AND password = '$pwd'");

    // $stmt->fetch(PDO::FETCH_ASSOC);

    // $stmt->fetch(PDO::FETCH_COLUMN);
 
    
    // $stmt->fetch(PDO::FETCH_NUM);
    //索引 "=>"左边的是有序的数值
    // [
    //     0=>1，
    //     1=>test,
    //     2=>wjx
    // ]

    //关联   "=>"左边的是字符串
    // [
    //     "id"=>1,
    //     "title"=>test,
    //     "content"=>wjx
    // ]
    // 保存id到session
    $_SESSION['id'] = $data['id'];
    // echo '<pre>';
    // var_dump($cc);
    // die;
    if($data){
        header("location:/blog/blog");
    }else{
        echo '失败！！';
    }
}
}