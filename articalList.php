<?php 
    header("Content-type:text/html;charset=utf-8"); 
    ini_set('date.timezone','Asia/Shanghai');
   @ $db = new mysqli('localhost','root','123456','myblog');
    if(!$db){
        echo "连接服务器出错，请重新连接。";
    }
    $query_insert = "select * from blog_artical order by create_time";
    $result = $db -> query($query_insert);
    $arr = array();
    while($row = $result -> fetch_object()){
        array_push($arr,$row);
    };
    echo json_encode($arr);
    $db -> close();
?>