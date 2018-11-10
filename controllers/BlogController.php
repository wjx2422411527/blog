<?php
namespace controllers;

use PDO;

class BlogController{
    public function test(){
        echo '<pre>';
        var_dump($_GET);
    }
    public function blog(){
        $model = new \models\Blog;
        // 调用方法
        $data = $model->blog();
        $ff = $model->getff();
        // echo"<pre>";
        // var_dump($data);die;
        // var_dump($ff);die;
        // 返回视图和传输数据   
        view('design/design',[
            'data' => $data['data'],
            'ff' => $ff,
            "ts"=>$data['ts'],
            "zy"=>$data['zy'],
            "dqy"=>$data['dqy']
        ]);
    }
    // 显示插入页面
    public function insert(){
        $data = new \models\Blog;
        $ff = $data->getcat();
        view('insert/insert',['ff' => $ff]);
    }
    // 执行插入方法
    public function toinsert(){
        $model = new \models\Blog;
        // 调用方法
        $data = $model->insert();
        if($data){
            header("location:/blog/blog");
        }else{
            echo '插入失败';
        }
    }
    // 删除方法
    public function del(){
        $model = new \models\Blog;
        // 调用方法
        $data = $model->del();
        if($data['ret']){ 
            echo   "<script>alert('确定删除');location.href='/blog/blog'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/blog/blog'</script>";
        }
    } 
    // 显示修改文件
    public function update(){
        $model = new \models\Blog;
        // 调用方法
        $data = $model->update();
        // 返回视图和传输数据
        view('insert/update',[
            'data' => $data
        ]);
    }
    // 执行修改方法
    public function toupdate(){
        $model = new \models\Blog;
        // 调用方法
        $data = $model->toupdate();
        if($data){
            header("location:/blog/blog");
        }else{
            echo '修改失败';
        }
    }
    public function ajax_get_cat(){
        $id = $_GET['id'];
        $model = new \models\Blog;
        $data = $model->ajax_get_cat($id);
        echo json_encode($data);
    }
}