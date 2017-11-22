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
    $query_time_artical = "select * from blog_artical order by create_time limit 3";
    $result_time_artical = $db ->query($query_time_artical);
    //获取最多浏览量的五条文章
    $query_views_artical = "select * from blog_artical order by page_views desc limit 5";
    $result_views_artical = $db -> query($query_views_artical);
    $row_views = $result_views_artical -> fetch_object(); 
    $view_first_title = $row_views -> artical_title;
    $view_first_view = $row_views -> page_views;
    $view_first_content = $row_views-> content;
    //php获取当前访问的完整url地址 
    function get_current_url(){ 
        $current_url='http://'; 
        if(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'){ 
            $current_url='https://'; 
        } 
        if($_SERVER['SERVER_PORT']!='80'){ 
            $current_url.=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; 
        }else{ 
            $current_url.=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
        } 
        return $current_url; 
    }
    $this_url = get_current_url();
    $this_id = (int)explode("?",$this_url)[1];
    // echo $this_id;
    //获取当前页面url上id的文章
    $query_this_page = "select * from blog_artical where artical_id = '".$this_id."'";
    $result_this_page = $db -> query($query_this_page);
    $row_this_page = $result_this_page ->fetch_object();
    
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
                            <a href='#'>js</a>
                            <span>(<?php echo $num_artical_js ?>)</span>
                        </li>
                        <li>
                            <a href='#'>css</a>
                            <span>(<?php echo $num_artical_css ?>)</span>
                        </li>
                        <li>
                            <a href='#'>php</a>
                            <span>(<?php echo $num_artical_php ?>)</span>
                        </li>
                        <li>
                            <a href='#'>nodeJS</a>
                            <span>(<?php echo $num_artical_nodeJS ?>)</span>
                        </li>
                        <li>
                            <a href='#'>随笔</a>
                            <span>(<?php echo $num_artical_suibi ?>)</span>
                        </li>
                        <li>
                            <a href='#'>连载小说</a>
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
                                        "<a href='".$row_views -> artical_url."'>".$row_views -> artical_title."</a>".
                                        "<span>(".$row_views -> page_views.")</a>".
                                    "</li>";
                            }
                        ?>
                    </ul>                    
                </div>
            </div>
        </div>
        <div class='content-right pull-right'>
            <div class='content-right-top' style='display:none;'>
                <h3>最新动态</h3>
                <ol start="1">
                    <?php 
                        while($row = $result_time_artical -> fetch_object()){
                            echo "<li>".
                                    "<span>".$row -> create_time."</span>".
                                    "<span>发布了文章</span>  ".
                                    "<a href=\"#\">".$row -> artical_title."</a>".
                                "</li>";
                        }
                    ?>
                </ol>
            </div>
            <div class='search' style='display:none'>
                <p style='position:relative;'>
                    <input type="text" placeholder='搜索你感兴趣的文章'>
                    <button>搜索</button>
                </p>
            </div>
            <div class='content-right-main'>
               <div class='artical-list-box'>
                   <ol class='articalList-ul'>

                   </ol>
               </div>
                <div class='index-right-content'>
                    <h3 style='background:#fff;padding-top:10px;'><a href='#' style='color:#000;'><?php 
                        echo $row_this_page -> artical_title;
                    ?></a></h3>
                    <p style='background:#fff;text-align:right;margin:0;padding:0 10px 10px 0;border-bottom:2px solid #f0ebeb;'>
                        <span>阅读量</span>
                        <span><?php echo $row_this_page->page_views; ?></span>
                    </p>
                    <div style='background:#fff;padding:20px;'>
                        <?php 
                            echo $row_this_page -> content;
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
        window.location = ''
        
    }
</script>
    
<?php
    $db -> close();
    include './temp/foot.php';
?>  
