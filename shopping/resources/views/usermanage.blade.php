<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .title {
            font-size: 5vh;
        }

        .m-b-md {
            position: absolute;
            top: 0px;
            left: 0px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="content">
        <div style="height:10vh;" class="title m-b-md">
            xx購物網帳號管理
        </div>
        <div id="userdiv" style="position:absolute;top:20vh;width:30vw;font-size:20px;">
            @section('show')
            <table class="table table-dark" id="usertable">
                <thead>
                    <tr>
                        <td>使用者名稱</td>
                        <td>管理</td>
                        <td>訂單</td>
                        <td>使用狀態</td>
                        <td>封/解鎖</td>
                    </tr>
                </thead>
                @foreach($usershow as $usershows)
                <tbody>
                    <tr>
                        <td id="nametd">{{$usershows->name}}</td>
                        <td><a id="datahref" href="{{url('/edit',$usershows->name)}}">資料管理</a></td>
                        <td><a href="{{url('/search',$usershows->name)}}">會員訂單</a></td>
                        <td>{{$usershows->status}}</td>
                        @if($usershows->status=='啟用')
                        <td><span><a id="banch" href="javascript:void(0)">封鎖</a></span></td>
                        @else
                        <td><span><a id="banch" href="javascript:void(0)">解鎖</a></span></td>
                        @endif
                    </tr>
                </tbody>
                @endforeach
            </table>
            @show
        </div>


    </div>
    <script>
       $('body').on('click','#banch', function () {
            var username = $(this).parents('tr').parents('tbody').find("#nametd").html();
            var banstatus = $(this).html();
            // alert($(this).parents('tr').find("#nametd").html());
            $.ajax({
                method: "post",
                url: "/ban",
                data: {
                    banstatus: banstatus,
                    username: username,
                    '_token': '{{csrf_token()}}',
                },
                success: function (e) {
                    $('#usertable').html(e.html);
                    console.log(e);
                }
            })
        })
    </script>
</body>

</html>