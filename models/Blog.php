<?php
namespace models;
use PDO;
use libs\Db;
class Blog{
    static public function blog(){
        //静态方法
        
        // 连接数据库
        $pdo = Db::make();
        // 定义需要的参数
        // 中条数
        // count(*)查询有多少条数据 
        //                      查询总共有多少条在 blogs 连接users条件是blogs
        $stmt = $pdo->db->query('SELECT count(*) FROM blogs LEFT JOIN users ON blogs.userid = users.id');
        //
        // 取出数据保存变量
        $ts = $stmt->fetch(PDO::FETCH_COLUMN);
        //把条数转换为int类型
        $ts = (int)$ts;
        // 每页显示几条
        $ys = 2;
        //查出总页 总条数除以当前要是显示的几条 上取整
        $zy = ceil($ts/$ys);
        //三目运算符 ? : ; 如果运算式等于true那就执行第一个值 如果等于false就执行第二个值
        $dqy = @$_GET['dqy']?@$_GET['dqy']:1;   
        //因为查询查询的数据时动态的所以SQL不固定
        $sql = 'SELECT blogs.*,users.user FROM blogs LEFT JOIN users ON blogs.userid = users.id';
        //name值必须有 没有就不执行
        if(@$_GET['keywords']){
            // 有的话拼接SQL
            $sql .=  " where content like '%".$_GET['keywords']."%' or title like '%".$_GET['keywords']."%'";
        }
        // 从零开始查询条
        // limit两个参数第一个参数 一从第几条开始取 二取几条
        $sql .= " limit ".(($dqy-1)*$ys).','.$ys;
        // 查询数
        $stmt = $pdo->db->query($sql);
        // 把查询出来的数据取出来
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";
        // var_dump($data);
        // 返回数据
        return [
            "data"=>$data,
            "ts"=>$ts,
            "zy"=>$zy,
            "dqy"=>$dqy
        ];
    }
    public function insert(){
        
        // 连接数据库
        $pdo = Db::make();
        // echo '<pre>';
        // var_dump($_POST,$_SESSION);
        $title = $_POST['title'];
        $content = $_POST['content'];
        $id = $_SESSION['id'];
        // 上传格式
        // 要不是格式就不能上传
        $type = [
            'image/gif',
            'image/jpeg',
            'image/jpg',
            'image/pjpeg',
            'image/x-png',
            'image/png'
        ];
        // 判断是否 logo值存在如果存在
        if(isset($_FILES['logo'])){
            // 把值传给$logo
            $logo = $_FILES['logo']; 
            // in_array数组是否存在制定的值
            // 如果数组中存在type格式正确   并且 reeor等0的
            //                                      reeor 不等于0的时候上传失败   等于0就上传成功
            if(in_array($logo['type'],$type) && $logo['error']==0){
                // 获取图片的名字
                $name = $logo['name'];
                // 获取后缀
                $suffix = strrpos($name,'.');
                // var_dump($suffix);die;
                // substr截取字符串 从后先前查找指定字符
                // ******substr
                $irt = substr($name,$suffix);
                // var_dump($irt);die;
                // 创建文件夹
                $path = '/uploads/blog/'.date('Y-m-d').'/';
                // 判断文件夹是否存在
                if(!file_exists(ROOT.'/public/'.$path)){
                //  自动创建文件夹 要创建的目录      权限最高权限 修改删除读写   设置递归
                    mkdir(ROOT.'/public/'.$path,0777,true);
                }
                // 取出随机数连接后缀
                $path .= rand(1,99999).$irt;
                //移动文件          要移动的文件        文件新地址 
                move_uploaded_file($logo['tmp_name'],ROOT.'/public/'.$path);
                //     /uploads/blog/2018.10.29/38159.jpg
            }
        }
        $ret = $pdo->db->exec("INSERT INTO blogs(title,content,userid,img) VALUES('$title','$content','$id','$path')");
        return $ret;
    }
    public function del(){
        // 连接数据库
        $pdo = Db::make();
        // 执行SQL 删除数据
        $id = $_GET['id'];  //14
        $ret = $pdo->db->exec("DELETE FROM blogs WHERE id = $id");
        // 返回数据 如果删除成功返回int(1) 插入失败返回false
        return $ret;
    }
    public function update(){
        // 连接数据库
        $pdo = Db::make();
        // 查询数据
        $id = $_GET['id'];
        $stmt = $pdo->db->query('SELECT * FROM blogs WHERE id = '.$id);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // 返回数据
        return $data;
    }
    public function toupdate(){
        // 连接数据库
        $pdo = Db::make();
        // 查询数据
        $title = $_POST['title'];
        $content = $_POST['content'];
        $id = $_GET['id'];
        $ret = $pdo->db->exec("UPDATE blogs SET title = ' $title',content = '$content' WHERE id = $id ");
        // 返回数据 如果修改成功返回int(1) 插入失败返回false
        return $ret; 
    }
    // 创建查询出来的方法
    public function getff(){
        // 连接数据库
        $pdo = Db::make();
        // 查询出数据库中所有数据
        $stmt = $pdo->db->query('SELECT * FROM cat');
        // 取处所有数据
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // 返回数据
        return $data;
    }
    public function getcat(){
        $pdo = Db::make();
        // 查询父id
        $stmt = $pdo->db->query('SELECT * FROM cat WHERE parent_id = 0');
        // 取出所有父id
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // 返回数据
        return $data;
    }
    public function ajax_get_cat($id){
        // 连接数据库
        $pdo = Db::make();
        // 
        $stmt = $pdo->db->query('SELECT * FROM cat WHERE parent_id = '.$id);
        // 取出全部数据
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // 返回数据
        return $data;
    }
}