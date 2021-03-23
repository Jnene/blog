var UI = {
    
    // 加载模态框
    alert:function(obj){
        // 初始化信息
        var title = (obj == undefined ||obj.title == undefined) ? '系统消息' : obj.title;
        var msg = (obj == undefined || obj.msg == undefined) ? '请输入用户名' : obj.msg;
        var icon = (obj == undefined|| obj.icon == undefined) ? '消息' : obj.icon;
        // 模态框
        var html ='<div class="modal fade" tabindex="-1" role="dialog" id="UI_alert_sm">\
                    <div class="modal-dialog modal-sm" role="document">\
                    <div class="modal-content">\
                        <div class="modal-header">\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                        <h4 class="modal-title" >'+title+'</h4>\
                        </div>\
                        <div class="modal-body">\
                        <div class="modal-body">\
                        <img src="./static/img/icon/'+icon+'.png" style="width:32px;height:32px;margin-right:5px;"></img>\
                        <span>'+msg+'</span>\
                        </div>\
                        </div>\
                        <div class="modal-footer">\
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->\
                        <button type="button" class="btn btn-primary" onclick="$(\'#UI_alert_sm\').modal(\'hide\')">确定</button>\
                        </div>\
                    </div>\
                    </div>\
                </div>'
            $('body').append(html);
            $('#UI_alert_sm').modal({'backdrop':'static','keyboard':false});
            $('#UI_alert_sm').modal('show');
            $('#UI_alert_sm').on('hidden.bs.modal', function (e) {
                $('#UI_alert_sm').remove();
            })
        },
        //加载登录页面
        open:function(obj) {
            var title = (obj == undefined ||obj.title == undefined) ? '' : obj.title;
            var url = (obj == undefined ||obj.url == undefined) ? '' : obj.url;
            var height = (obj == undefined ||obj.height == undefined) ? 350 : obj.height;
            var width = (obj == undefined ||obj.width == undefined) ? 550 : obj.width;
            var html ='<div class="modal fade" tabindex="-1" role="dialog" id="UI_open">\
                    <div class="modal-dialog modal-lg" role="document">\
                    <div class="modal-content">\
                        <div class="modal-header" style="padding:15px;margin-bottom:-7px;padding-bottom:0px;">\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                        <h4 style="font-size:15px!important;">'+title+'</h4>\
                        </div>\
                        <div class="modal-body">\
                        <iframe src="'+url+'" style="width:'+(width-25)+'px!important;height:'+(height-100)+'px;" frameborder="0">\
                        </div>\
                    </div>\
                    </div>\
                </div>'
            $('body').append(html);
            $('#UI_open .modal-lg').css('width',width+'px');
            $('#UI_open .modal-content').css('height',height+'px');
            $('#UI_open').modal({'backdrop':'static','keyboard':false});
            $('#UI_open').modal('show');
            $('#UI_open').on('hidden.bs.modal', function (e) {
                $('#UI_open').remove();
            })
        }
}