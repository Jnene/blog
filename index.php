<?php 
    header("Content-type:text/html;charset=utf-8");
    include_once('./db.php');
    $r=new db();
    $whe = "id>0 ";
    $sort=null;
    if(isset($_GET['vmod'])){
        $vmod=$_GET['vmod'];
        $sort = $vmod==='1' ?'add_time':'view_num';
    }   
    if(isset($_GET['cid'])){
        $cid=$_GET['cid'];
        $path='./index.php?cid='.$cid;
        $whe.="and cid=$cid";
    }
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        $page_size=6;
        $s=$r->column('id,title,view_num,add_time')->order($sort)->table('test_info')->where($whe)->page($page,$page_size,$path);
    }

?>
<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jnene's blog</title>
    <link rel="stylesheet" href="./static/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/css/index.main.css">
    <script src="./static/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="./static/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="./static/js/ui.js"></script>
</head>
<body>
    <div class="head">
        <div class="container">
            <span class="title">Jnene's blog</span>
            <div class="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="输入博客标题搜索...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">搜索</button>
                    </span>
                </div>
            </div>
            <div class="login-reg">
                <?php
                    session_start();
                    $user=$_SESSION['user'];
                ?> 
                <?php if($user){?> 
                    <span style="margin-right:20px;"><?php echo $user['uname'];?></span>
                    <button type="button" class="btn btn-success" onclick="outlogin()">登出</button>
                <?php }else{?>
                    <button type="button" class="btn btn-success" onclick="login()">登入</button>
                <?php }?>
                <button type="button" class="btn btn-info" onclick="addArticle()">发表博客</button>
            </div>
        </div>  
    </div>
    <div class="main container">
        <div class="col-lg-3 col-xs-3 left-container">
            <p class="cates">博客分类</p>
            <div class="cate-list">
                <div class="cate-item"><a href="./index.php?cid=1&page=1">编程语言</a></div>
                <div class="cate-item"><a href="./index.php?cid=2&page=1">CTF</a></div>
                <div class="cate-item"><a href="./index.php?cid=3&page=1">渗透测试</a></div>
                <div class="cate-item"><a href="./index.php?cid=4&page=1">其他分类</a></div>
                <div class="cate-item"><a href="">开发中...</a></div>
                <div class="cate-item"><a href="">开发中...</a></div>
                <div class="cate-item"><a href="">开发中...</a></div>
            </div>
        </div>
        <div class="col-lg-9 col-xs-9 right-container">
            <div class="nav">
                <a onclick="getGet(1)">热门</a>
                <a  onclick="getGet(0)" class="active">最新</a>
            </div>
                                <div class="contant-list">
                                    <?php if($s[0]>0){?>
                                    <?php foreach($s[1] as $value){?>
                                    <div class="contant-item">
                                        <img src="./static/img/1.jpg" alt="">
                                        <div class="title">
                                            <p><a href="./detail.php?id=<?php echo $value['id']?>"><?php echo $value[title]?></a></p>
                                            <span>浏览量：<?php echo $value[view_num]?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <span>发布时间：<?php echo date('Y-m-d H:i:s',$value[add_time])?></span>
                                        </div>
                                    
                                    </div> 
                                    <?php }}?>
                                </div>            
            <?php echo $s[2]?>
        </div>
    </div>
      <script>
          function login(){
            UI.open({'title':'登入','url':'./login.php','width':600});
          }
          function outlogin(){
            $.get('./service/outlogin.php',function(res){
                UI.alert({'msg':res.msg});
                setTimeout(function(){parent.window.location.reload();},2000);
            },'json');
          }
          function addArticle(){
            <?php if(!$user){?>
                UI.alert({'msg':'请先登录'});  
            <?php }else{?>   
            UI.open({'title':'发表博客','url':'./service/addArticle.php','width':750,'height':650});
            <?php }?>
          }
          function getGet(flag){
            var a = location.href;
            a=a.split('?');
            window.location =a[0]+"/?"+a[1]+"&vmod="+flag;
          }
      </script>
</body>
</html>