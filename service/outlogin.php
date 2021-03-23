<?php
    session_start();
    $_SESSION['user']=null;
    exit(json_encode(array('code'=>0,'msg'=>'操作成功')));