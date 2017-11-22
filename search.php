<?php 
    header("Content-type:text/html;charset=utf-8"); 
    ini_set('date.timezone','Asia/Shanghai');
   @ $db = new mysqli('localhost','root','123456','myblog');
    if(!$db){
        echo "连接服务器出错，请重新连接。";
    }
    $keyword = trim($_POST["keyword"]);
    $query_search = "select * from blog_artical where content like '%".$keyword."%' or artical_title like  '%".$keyword."%' ";
    $result_search = $db -> query($query_search);
    $arr_search = array();
    while($row_search = $result_search -> fetch_object()){
        array_push($arr_search,$row_search);
    };
    echo json_encode($arr_search);
    $db -> close();
?>