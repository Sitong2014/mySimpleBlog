<?php
    include './temp/head.php';
?>
<link rel="stylesheet" href="./public/css/index.css">
</head>
<body>
<?php
    include './temp/header.php';
    @ $db = new mysqli('localhost','root','123456','myblog');
    if(!$db){
        echo '数据库连接失败:'.mysqli_connect_errno();
    }
    $query_1 = "select * from blog_artical where blog_artical.artical_type = 'js' ";
    $query_2 = "select * from blog_artical where blog_artical.artical_type = 'css' ";
    $query_3 = "select * from blog_artical where blog_artical.artical_type = 'php' ";
    $query_4 = "select * from blog_artical where blog_artical.artical_type = 'nodeJS' ";
    $query_5 = "select * from blog_artical where blog_artical.artical_type = '随笔' ";
    $query_6 = "select * from blog_artical where blog_artical.artical_type = '连载小说' ";
    $result_js = $db -> query($query_1);
    $result_css = $db -> query($query_2);
    $result_php = $db -> query($query_3);
    $result_nodeJS = $db -> query($query_4);
    $result_suibi = $db -> query($query_5);
    $result_lianzai = $db -> query($query_6);
    $num_artical_js = $result_js -> num_rows;
    $num_artical_css = $result_css -> num_rows;
    $num_artical_php = $result_php -> num_rows;
    $num_artical_nodeJS = $result_nodeJS -> num_rows;
    $num_artical_suibi = $result_suibi -> num_rows;
    $num_artical_lianzai = $result_lianzai -> num_rows;

    //按时间获取最新的三条文章
    $query_time_artical = "select * from blog_artical order by create_time desc limit 3";
    $result_time_artical = $db ->query($query_time_artical);
    //获取最多浏览量的五条文章
    $query_views_artical = "select * from blog_artical order by page_views desc limit 5";
    $result_views_artical = $db -> query($query_views_artical);
    $row_views = $result_views_artical -> fetch_object(); 
    $view_first_title = $row_views -> artical_title;
    $view_first_view = $row_views -> page_views;
    $view_first_content = $row_views-> content;
    function getArtical($d,$o){
        $query_js_artical = "select * from blog_artical where blog_artical.artical_type='".$o."'";
        $result_js_artical = $d -> query($query_js_artical);
        return $result_js_artical;
    }
    @ $js_result = getArtical($db,js);
    @ $css_result = getArtical($db,css);
    @ $php_result = getArtical($db,php);
    @ $nodeJS_result = getArtical($db,nodeJS);
    @ $suibi_result = getArtical($db,随笔);
    @ $lianzai_result = getArtical($db,连载小说);
    // $query_js_artical = "select * from blog_artical where blog_artical.artical_type='js' ";
    // $result_js_artical = $db -> query($query_js_artical);
    // $row_js_artical = $result_js_artical -> fetch_object();
    // print_r($row_js_artical);
    
?>
<div class='container'>
    <div class='content clearfix'>
        <div class='content-left pull-left'>
            <div class='avatar'>
                <div class='avatar-box'>
                    <img src="./public/images/avatar.jpg" alt="">
                </div>
            </div>
            <div class='info-box'>
                <div class='info-top'>
                    <p>
                        <span>MD_Ghost，26岁的单身狗</span>
                    </p>
                    <p>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;一个有梦想的前端码农</span>
                    </p>
                </div>
                <div class='info-mid'>
                    <span class='info-mid-title'>文章分类</span>
                    <ul class='artical-type'>
                        <li>
                            <a href='javascript:void(0);' id='js_articalList'>js</a>
                            <span>(<?php echo $num_artical_js ?>)</span>
                        </li>
                        <li>
                            <a href='javascript:void(0);' id='css_articalList'>css</a>
                            <span>(<?php echo $num_artical_css ?>)</span>
                        </li>
                        <li>
                            <a href='javascript:void(0);' id='php_articalList'>php</a>
                            <span>(<?php echo $num_artical_php ?>)</span>
                        </li>
                        <li>
                            <a href='javascript:void(0);' id='nodejs_articalList'>nodeJS</a>
                            <span>(<?php echo $num_artical_nodeJS ?>)</span>
                        </li>
                        <li>
                            <a href='javascript:void(0);' id='suibi_articalList'>随笔</a>
                            <span>(<?php echo $num_artical_suibi ?>)</span>
                        </li>
                        <li>
                            <a href='javascript:void(0);' id='lianzai_articalList'>连载小说</a>
                            <span>(<?php echo $num_artical_lianzai ?>)</span>
                        </li>
                    </ul>
                </div>
                <div class='info-bottom'>
                    <span class='info-bottom-title'>最受欢迎文章</span>
                    <ul>
                        <?php 
                            while($row_views = $result_views_artical -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$row_views -> artical_id."'>".$row_views -> artical_title."</a>".
                                        "<span>(".$row_views -> page_views.")</a>".
                                    "</li>";
                            }
                        ?>
                    </ul>                    
                </div>
            </div>
        </div>
        <div class='content-right pull-right'>
            <div class='content-right-top'>
                <h3>最新动态</h3>
                <ol start="1">
                    <?php 
                        while($row = $result_time_artical -> fetch_object()){
                            echo "<li>".
                                    "<span>".$row -> create_time."</span>".
                                    "<span>发布了文章</span>  ".
                                    "<a href='./artical.php?".$row -> artical_id."'>".$row -> artical_title."</a>".
                                "</li>";
                        }
                    ?>
                </ol>
            </div>
            <div class='search'>
                <p style='position:relative;'>
                    <input type="text" id='ipt-search' placeholder='搜索你感兴趣的文章'>
                    <button id='btn_search'>搜索</button>
                </p>
                <p>
                    <ol id='search-ul' style='display:none;'>
                        
                    </ol> 
                </p>
            </div>
            <div class='content-right-main'>
               <div class='artical-list-box' >
                    <ol class='a-u articalList-ul-js' style='display:none;'>
                        <?php
                             while($js_row = $js_result -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$js_row -> artical_id."'>".$js_row -> artical_title."</a>".
                                    "</li>";
                             }
                        ?>
                   </ol>
                   <ol class='a-u articalList-ul-css' style='display:none;'>
                        <?php
                             while($css_row = $css_result -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$css_row -> artical_id."'>".$css_row -> artical_title."</a>".
                                    "</li>";
                             }
                        ?>
                   </ol>
                   <ol class='a-u articalList-ul-php' style='display:none;'>
                        <?php
                             while($php_row = $php_result -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$php_row -> artical_id."'>".$php_row -> artical_title."</a>".
                                    "</li>";
                             }
                        ?>
                   </ol>
                   <ol class='a-u articalList-ul-node' style='display:none;'>
                        <?php
                             while($node_row = $nodeJS_result -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$node_row -> artical_id."'>".$node_row -> artical_title."</a>".
                                    "</li>";
                             }
                        ?>
                   </ol>
                   <ol class='a-u articalList-ul-suibi' style='display:none;'>
                        <?php
                             while($suibi_row = $suibi_result -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$suibi_row -> artical_id."'>".$suibi_row -> artical_title."</a>".
                                    "</li>";
                             }
                        ?>
                   </ol>
                   <ol class='a-u articalList-ul-lianzai' style='display:none;'>
                        <?php
                             while($lianzai_row = $lianzai_result -> fetch_object()){
                                echo "<li>".
                                        "<a href='./artical.php?".$lianzai_row -> artical_id."'>".$lianzai_row -> artical_title."</a>".
                                    "</li>";
                             }
                        ?>
                   </ol>
                   <ol class='articalList-ul' style='display:none;'>
                   </ol>
               </div>
                <div class='index-right-content'>
                    <h3 style='background:#fff;padding-top:10px;'><a href='#' style='color:#000;'><?php 
                        $result_views_artical = $db -> query($query_views_artical);
                        $row_views = $result_views_artical -> fetch_object(); 
                        echo $row_views -> artical_title;
                    ?></a></h3>
                    <p style='background:#fff;text-align:right;margin:0;padding:0 10px 10px 0;border-bottom:2px solid #f0ebeb;'>
                        <span>阅读量</span>
                        <span><?php echo $view_first_view; ?></span>
                    </p>
                    <div style='background:#fff;padding:20px;'>
                        <?php 
                            echo $view_first_content;
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js'></script>
<script>
    function into_articalList(){
        $(".artical-list-box").css("display","block");
        $(".index-right-content").css("display","none");
        $.ajax({
            async:true,
            type:"post",
            dataType:"text",
            url:"/myblog/articalList.php",
            data:{
            },
            success:function(data){
                var res = JSON.parse(data);
                console.log(res[0]);
                var title_arr = data.split(",");
                if($(".articalList-ul").has("li").length == 0){
                    $(".a-u").css("display","none");
                    $(".articalList-ul").css("display","block");
                    for(var i = 0;i<res.length;i++){
                        $(".articalList-ul").append("<li><a href='./artical.php?"+res[i].artical_id+"'>"+res[i].artical_title+"</a></li>");   
                    };
                };
                
            },
            error:function(data, XMLHttpRequest, textStatus, errorThrown){  
                console.log(data);  
                console.log(XMLHttpRequest.status);  
                console.log(XMLHttpRequest.readyState);  
                console.log(textStatus);  
            }  
        })
    }
    function getList(obj,ul){
        $(obj).on("click",function(){
            $(".index-right-content").css("display","none");
            $(".articalList-ul").css("display","none");
            $(ul).siblings(".a-u").css("display","none");
            $(ul).css("display","block");
        })
    }
    getList("#js_articalList",".articalList-ul-js");
    getList("#css_articalList",".articalList-ul-css");
    getList("#php_articalList",".articalList-ul-php");
    getList("#nodejs_articalList",".articalList-ul-node");
    getList("#suibi_articalList",".articalList-ul-suibi");
    getList("#lianzai_articalList",".articalList-ul-lianzai");
    
    //搜索ajax
    function Trim(str)
    { 
        return str.replace(/(^\s*)|(\s*$)/g, ""); 
    }
    $("#btn_search").click(function(){
        $("#search-ul").css("display","block").html("");
        var keyword = $("#ipt-search").val();
        if(keyword != ""){
            $.ajax({
                async:true,
                type:"post",
                dataType:"text",
                url:"/myblog/search.php",
                data:{
                    "keyword":keyword
                },
                success:function(data){
                    var res = JSON.parse(data);
                    console.log(res);
                    for(var i = 0;i<res.length;i++){
                        $("#search-ul").append("<li><a href='./artical.php?"+res[i].artical_id+"'>"+res[i].artical_title+"</a></li>");   
                    };
                },
                error:function(err){
                    console.log(err);
                }
            })
        }else{
            $("#search-ul").css("display","none")
        }
        
        
    });
    
</script>
    
<?php
    $db -> close();
    include './temp/foot.php';
?>  
