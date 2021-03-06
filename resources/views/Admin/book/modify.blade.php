<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>修改书籍</title>
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/admin/css/font.css">
    <link rel="stylesheet" href="/admin/css/xadmin.css">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/js/webuploader/webuploader.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/admin/js/xadmin.js"></script>
    <script src="/js/jquery.form.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/webuploader/webuploader.js"></script>
    <script type="text/javascript" src="/js/webuploader/getting-started.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="x-body">
    <form class="layui-form" id="form">
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                ID
            </label>
            <div class="layui-input-inline">
                <input type="text" id="id" name="id" required="" value="{{$id}}"  lay-verify="ISBN" class="layui-input" onfocus=this.blur()>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                ISBN
            </label>
            <div class="layui-input-inline">
                <input type="text" id="ISBN" name="ISBN" required="" value="{{$ISBN}}"  lay-verify="ISBN" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                书名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" value="{{$name}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                封面
            </label>
            <div class="layui-input-inline">
                <!--dom结构部分-->
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list">
                        <input type="hidden" name="avatar" value=""/>
                    </div>
                    <div id="filePicker">选择图片</div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                作者
            </label>
            <div class="layui-input-inline">
                <input type="text" id="book_author" name="book_author" value="{{$book_author}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                出版社
            </label>
            <div class="layui-input-inline">
                <input type="text" id="press" name="press" value="{{$press}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                出版时间
            </label>
            <div class="layui-input-inline">
                <input type="text" id="publication_time" name="publication_time" value="{{$publication_time}}" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                入库时间
            </label>
            <div class="layui-input-inline">
                <input type="text" id="add_time" name="add_time" value="{{$add_time}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                库存
            </label>
            <div class="layui-input-inline">
                <input type="text" id="number" name="number" value="{{$number}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                分类
            </label>
            <div class="layui-input-inline">
                <select class="cs-select cs-skin-underline" id="selectId">
                    @foreach($dbclass as $key=>$value)
                        <option value="{{$value->id}}">{{$value->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="save" lay-submit="">
                修改
            </button>
        </div>
    </form>
</div>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#publication_time' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#add_time' //指定元素
        });
    });


        layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //监听提交
        form.on('submit(save)', function(data){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            var formdata = $('#form').serialize();
            var str =$('#selectId').val();
            $.ajax({
                layerIndex:-1,
                beforeSend: function () {
                    this.layerIndex = layer.load(3, { shade: [0.5, '#393D49'] });
                },
                type:'POST',
                url:'/admin/book/modify',
                data:formdata+"&value="+str,
                dataType:'json',
                success:function(result){
                    if(result){
                        layer.msg('修改成功!', {icon: 1, time: 1000});
                    }else {
                        layer.msg('修改失败!', {icon: 2, time: 2000});
                    }
                },
                complete: function () {
                    layer.close(this.layerIndex);
                },
                error:function(){
                    layer.msg('修改失败!', {icon: 2, time: 2000});
                }
            });
            return false;
        });
    });
</script>
</body>

</html>