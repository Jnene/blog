<?php
header("Content-type:text/html;charset=utf-8");
// 验证用户 
    session_start();
    $user=$_SESSION['user'];
    if(!$user){
        exit(json_encode(array('code'=>1,'msg'=>'请先登录')));
    }
// 获取前端数据及处理
    if($_POST['title'] && $_POST['class'] && $_POST['keywords'] && $_POST['content']){
        $data['title']=addslashes(trim($_POST['title'].' '));
        $class=addslashes(trim($_POST['class']));
        $data['keywords']=addslashes(trim($_POST['keywords'],' '));
        $content=addslashes(trim($_POST['content'],' '));
    }else{
        exit(json_encode(array('code'=>1,'msg'=>'请填写完整博客信息')));
    }
    $data['add_time']=time();
// 数据库
    include_once($_SERVER['DOCUMENT_ROOT'].'/jnene/db.php');
    $r=new db();
    $cid=($r->table('class_essay')->column('cid')->where(array('ctitle'=>$class))->item());
    $data['cid']=(int)$cid['cid'];
    // 插入文章信息
    $add_info=$r->table('test_info')->insert($data);
    if(!$add_info){
        exit(json_encode(array('code'=>1,'msg'=>'插入信息失败')));
    }
    // 插入文章数据
    $add_content=$r->table('test_content')->insert(array('content'=>$content,'id'=>$add_info));
    if(!$add_content){
        exit(json_encode(array('code'=>1,'msg'=>'插入内容失败')));
    }
    exit(json_encode(array('code'=>0,'msg'=>'保存成功')));