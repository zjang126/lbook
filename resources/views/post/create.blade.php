@extends('layout.main')
@section('content')
    <div class="col-sm-8 blog-main">
        <form action="/posts" method="POST" >
            {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
            {{csrf_field()}}
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" placeholder="这里是标题">
            </div>
            <div class="form-group">
                <label>内容</label>
                <tr>
                    <th>文章内容：</th>
                    <td>
                        <script type="text/javascript" charset="utf-8" src="/org/ueditor/ueditor.config.js"></script>
                        <script type="text/javascript" charset="utf-8" src="/org/ueditor/ueditor.all.min.js"> </script>
                        <script type="text/javascript" charset="utf-8" src="/org/ueditor/lang/zh-cn/zh-cn.js"></script>
                        <script id="editor" name="content" type="text/plain" style="width:600px;height:400px;"></script>
                        <script type="text/javascript">
                            var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 20px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                    </td>
                </tr>
            </div>
            @include('layout.error')
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <br>

    </div><!-- /.blog-main -->
@endsection
