<?php
// 获取文章分类标签的内容
    include_once('../db.php');
    $r=new db();
    $classArticle=$r->table('class_essay')->column('ctitle')->lists();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发布博客</title>
    <link rel="stylesheet" href="../static/plugins/bootstrap/css/bootstrap.min.css">
    <script src="../static/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="../static/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../static/js/ui.js"></script>
    <script src='../static/plugins/wangeditor/dist/wangEditor.min.js'></script>
    <style>
        .input-group{margin:5px;z-index:0;}
        #btn{float:right;}
        #div1{z-index:-1;}
    </style>
</head>
<body>
        <div class="row">
            <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon " id="sizing-addon2">&nbsp;&nbsp;&nbsp;文章标题</span>
                    <input type="text" class="form-control title" placeholder="Title" aria-describedby="sizing-addon2">
                </div>
            </div>
            <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2">&nbsp;&nbsp;&nbsp;文章分类</span>
                    <select class="form-control classify">
                        <?php foreach($classArticle as $value){?>
                            <option value="<?php echo $value['ctitle'];?>"><?php echo $value['ctitle'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2">文章关键字</span>
            <input type="text" class="form-control keywords" placeholder="Keywords" aria-describedby="sizing-addon2">
        </div>
        <div class="input-group">
            <div id="div1">
                <p></p>
            </div>
        </div>
        <div id="btn">
            <button type="button" class="btn btn-info" onclick="save()">保存</button>
        </div>
        
        


</body>
</html>
<script type="text/javascript">
    var editor;
    function subPage(){
        const E = window.wangEditor;
        editor = new E('#div1');
        editor.config.zIndex = 0;
        editor.config.uploadFileName = 'Upimg'
        editor.config.uploadImgServer = 'upload.php';
        editor.create();
    }
    subPage();
    function save(){
        var data=new Object;
        data.title=$.trim($(".title").val());
        data.class=$.trim($(".classify option:selected").text());
        data.keywords=$.trim($(".keywords").val());
        data.content=$.trim(editor.txt.html());
        $.post('./subArticle.php',data,function(res){
            UI.alert({'msg':res.msg});
            if(res.code==0){
                setTimeout(function(){parent.window.location.reload();},2000);
            }
            
        },'json');
    }
           
</script>