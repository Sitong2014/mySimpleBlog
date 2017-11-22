<?php
    class page{
        //属性
        public $content;
        public $title = 'MD_GHOST的blog';
        public $nav = array("主页"=>"home.php",
                            "技术文章"=>"artical.php",
                            "关于"=>"about.php",
                            "联系我"=>"connect.php");
        //方法
        public function __set($name,$value){
            $this -> $name = $value;
        }
        public function Display(){
            $head_html = "<!DOCTYPE html>".
                            "<html lang=\"en\">".
                            "<head>".
                                "<meta charset=\"UTF-8\">".
                                "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">".
                                "<meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">";
                           
            echo $head_html;
            $this -> DisplayTitle();
            $this -> DisplayStyle();
            echo "</head>\n<body>";
            $this -> DisplayHeader($this->nav);
            // $this -> DisplayNav();
            echo $this -> content;
            $this -> DisplayFooter();
            echo "</body>".
                  "</html>";
        }
        public function DisplayTitle(){
            echo "<title>".$this -> title."</title>";
        }
        public function DisplayStyle(){
        ?>
        <style>
            *{
                margin:0;
                padding:0;
            }
            li{
                list-style-type:none;
            }
            a{
                color:#fff;
                text-decoration:none;
            }
            a:active,a:visited{
                color:#fff
            }

            .header{
                width:100%;
                height:50px;
                background:#000;
                color:#fff;
            }
            .talk{
                padding-left:50px;
                line-height:50px;
            }
            .pull-left{
                float:left!important;
            }
            .pull-right{
                float:right!important;
            }
            .clearfix:before{
                display:table;
            }
            .clearfix:after{
                content:"";
                display:table;
                clear:both;
            }
            .nav{
                padding-right:50px;
                line-height:50px;
            }
            .nav ul a{
                float:left;
                margin-left:20px;
            }
            .footer{
                width:100%;
                height:40px;
                line-height:40px;
                background:#000;
                color:#fff;
                text-align:center;
            }
            
        </style>
        <?php
        }
        public function DisplayHeader($o){
        ?>
        <div class='header clearfix'>
            <div class='talk pull-left'>
                <span>孤独的风中一只鬼</span>
            </div>
            <div class='nav pull-right'>
                <ul class='clearfix'>
                <?php
                    $this -> DisplayNav($o);
                ?>
                </ul>
            </div>
        </div>
        <?php
        }
        public function DisplayNav($o){
            while(list($na,$url) = each($o)){
                echo "<a href='".$url."'><li>".$na."</li></a>";
            }
        }

        public function DisplayFooter(){
        ?>
            <div class='footer'>
                <span>this is MD_ghost's blog.welcome to connect me.</span>
            </div>
        <?php
        } 
    }
?>