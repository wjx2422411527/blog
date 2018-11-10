<?php
namespace controllers;

class RegistController{
    // 显示注册的表单
    public function regist(){
        view("regist/regist");
    }
    // 注册表单 提交的方法
    public function zhuce(){
        // new 一个模型  的 类
        // 控制器 和  模型  都是  类  只不过  用法不一样  所以叫法也不一样
         $model = new \models\Regist;
         $model->regist($_POST);
    }
}