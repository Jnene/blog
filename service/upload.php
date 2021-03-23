<?php
    if($_FILES['Upimg']['error']>0){
        exit(json_encode(array('errno'=>1,'data'=>[])));
    }
    
    $tpmimg=$_FILES['Upimg']['tmp_name'];//图片缓存名称
    $source = iconv("UTF-8","GBK//IGNORE",'./img/');
    $nameImg=time();
    $topath='./upload/img/'.$nameImg.$_FILES['Upimg']['name'];//图片保存路径
    //判断文件类型，mime
    $fi = new finfo(FILEINFO_MIME_TYPE);
    $type = $fi->file($tpmimg);
    $allow_type=['image/jpeg','image/png'];
    if(!in_array($type,$allow_type)){
        exit(json_encode(array('errno'=>1,'data'=>[])));
    }
    //返回信息
    if(move_uploaded_file($tpmimg,$topath)){
        exit(json_encode(array('errno'=>0,'data'=>[$topath])));
    }else{
        exit(json_encode(array('errno'=>1,'data'=>[])));
    }

