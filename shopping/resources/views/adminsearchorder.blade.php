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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="content">
        <div style="height:10vh;" class="title m-b-md">
            xx購物網後台
        </div>
        <div style="position:absolute;top:10vh">
            <span>請選擇查詢方式:</span>
            <select id="selectway">
                <option value="1">特定帳戶</option>
                <option value="2">訂單號碼</option>
                <option value="3">特定商品</option>
                <option value="4">日期區間</option>
            </select>
            <input class="form-control" id="myInput" type="text" />
            <button id="btnOK">確定</button>
            @section('resault')
            <ul id="resaultul">
                @foreach($ordershow as $show)
            <li class="list-group-item"><a href="{{url('/orderdetail',$show->orderId)}}">{{$show->orderId}}</a></li>
                @endforeach
            </ul>
            @show
        </div>


    </div>
    <script>
        var way=0;
        $('#selectway').change(function () {
            way = $(this).val();
            console.log(way);
        })
        $('#btnOK').on('click', function () {
            var searchtext = $('#myInput').val();

            $.ajax({
                type: "post",
                url: '/ordershow',
                data: {
                    way: way,
                    text: searchtext,
                    '_token': '{{csrf_token()}}'
                },
                success: function (a) {
                    $('#resaultul').html(a.html);
                    console.log(a);
                }
            })
           
        })

       
    
    </script>
</body>

</html>