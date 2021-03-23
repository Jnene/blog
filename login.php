
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
    <link rel="stylesheet" href="./static/plugins/bootstrap/css/bootstrap.min.css">
    <script src="./static/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="./static/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="./static/js/ui.js"></script>
    <style>
        .title{text-align:center;font-size:20px;}
        .input-group{margin:20px;width:400px;text-align:center;}
        .login-form .btn-login{text-align:center;}
    </style>
</head>
<body>
    <div class='login-form'>
        <div class='title'>登录博客</div>
        <div class='input-login'>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">用户名</span>
                <input type="text" id="uname" class="form-control" placeholder="Username" aria-describedby="sizing-addon2">
            </div>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">&nbsp;密&nbsp;&nbsp;&nbsp;码</span>
                <input type="password" id="pword" class="form-control" placeholder="Password" aria-describedby="sizing-addon2">
            </div> 
        </div>
        <div class='btn-login'>
            <button type="button" class="btn btn-success" onclick="login()">登录</button>
        </div>
    </div>
    <script>
        function login(){
            var uname=$.trim($('#uname').val());
            var pword=$.trim($('#pword').val());
            if(uname=='' || pword ==''){
                UI.alert({'msg':'用户名或密码不能为空'});
                return false;
            }
            $.post("./service/dologin.php",{uname:uname,pword:pword},function(res){
                if(res.code>0){
                    UI.alert({'msg':res.msg});
                }else{
                    UI.alert({'msg':res.msg});
                    setTimeout(function(){parent.window.location.reload();},2000);
                }
            },'json');
        }
    </script>
</body>
</html>