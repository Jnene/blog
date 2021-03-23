<?php 
    header("Content-type:text/html;charset=utf-8");
    include_once('./db.php');
    $r=new db();
    //查找文章内容
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $s=$r->column('title')->table('test_info')->where("id=$id")->item();
        
        $content=$r->column('content')->table('test_content')->where("id=$id")->item();
        // echo "<pre>";
        // exit(var_dump($content));
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
    <style>
        .content-title{text-align:center;font-size:20px;margin-top:10px;margin-bottom:-15px;}
    </style>
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
                <div class="cate-item"><a href="">编程语言</a></div>
                <div class="cate-item"><a href="">CTF</a></div>
                <div class="cate-item"><a href="">渗透测试</a></div>
                <div class="cate-item"><a href="">其他分类</a></div>
                <div class="cate-item"><a href="">开发中...</a></div>
                <div class="cate-item"><a href="">开发中...</a></div>
                <div class="cate-item"><a href="">开发中...</a></div>
            </div>
        </div>
        <div class="col-lg-9 col-xs-9 right-container">
            <div class="nav">
                <a href="">热门</a>
                <a href="" class="active">最新</a>
            </div>
            <div class="contant-list text">
                <div class='content-title'><?php echo $s['title'];?></div><hr>
                <div><?php echo $content['content'];?></div>
            </div>
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
      </script>
</body>
</html>