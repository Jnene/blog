<?php
    // 登录验证
    $uname=$_POST['uname'];
    $pword=$_POST['pword'];
    include_once('../db.php');
    $r=new db();
    $user=$r->table('users')->where(array('uname'=>$uname))->item();
    if(!$user){
        exit(json_encode(array('code'=>1,'msg'=>'用户名或密码错误')));
    }
    if($user['pword']!==$pword){
        exit(json_encode(array('code'=>1,'msg'=>'用户名或密码错误')));
    }
    // 会话设置
    session_start();
    $_SESSION['user']=$user;
    exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
?>