<?php
session_start();
define('ROOT',__DIR__.'/../');
function wjx($class){
    $hc = str_replace('\\','/',$class);
    require(ROOT.$hc.'.php');
}
spl_autoload_register('wjx');
if(isset($_SERVER['PATH_INFO'])){
   $zh = explode('/',$_SERVER['PATH_INFO']);
    $pj = '\Controllers\\'.ucfirst($zh[1]).'Controller';
    $ff = $zh[2];
}
else
{
    $pj = '\Controllers\IndexController';
    $ff = 'index';
}
$a = new $pj;
$a->$ff();



function view($file,$data=[])
{
    extract($data);
    include(ROOT . 'views/'.$file.'.html');
}

