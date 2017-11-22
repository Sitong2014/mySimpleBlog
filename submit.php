<?php
    header("Content-type:text/html;charset=utf-8"); 
    ini_set('date.timezone','Asia/Shanghai');
    $time = date("Y-m-d H:i:s");
    // $data = $_POST['data'];
    // $data = json_decode($data, true);
    // print_r($data);
    // $data = json_decode($_POST['data'], true);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];
    $img = "";
    $views = 0;
    $url = "";
    echo json_encode($time);
    echo json_encode($content);
    echo json_encode($type);
    echo json_encode($title);
    @ $db = new mysqli('localhost','root','123456','myblog');
    if(!$db){
      echo "连接服务器出错，请重新连接。";
    }
    $query_insert = " insert into blog_artical values
                        (null,'".$type."','".$title."','".$content."','".$views."','".$img."','".$time."','".$url."')";
    $result = $db -> query($query_insert);
    if($result){
        echo "插入成功。";
    }else{
        echo "插入失败。";
    }
    $db -> close();
?>