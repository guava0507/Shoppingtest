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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
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
            <div id="datapick" style="display:none;position:absolute;top:3vh">
                <input id="datepicker1" data-date-format="dd/mm/yyyy" width="270" />
                <input style="position:absolute;left:12vw" id="datepicker2" data-date-format="dd/mm/yyyy" width="270" />
            </div>
            <input class="form-control" id="myInput" type="text" />
            <button style="position:absolute;top:6vh;left:3vw" id="btnOK">確定</button>
            @section('resault')
            <ul id="resaultul" style="position:absolute;top:15vh">
                @foreach($ordershow as $show)
                <li class="list-group-item"><a href="{{url('/orderdetail',$show->orderId)}}">{{$show->orderId}}</a></li>
                @endforeach
            </ul>
            @show
        </div>


    </div>
    <script>
        $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4',
            autoclose: true
        })
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            autoclose: true
        })
        var way = 0;
        $('#selectway').change(function () {
            way = $(this).val();
            console.log(way);
            if (way == 4) {
                $('#datapick').css({
                    'display': 'block'
                })
                $('#myInput').css({
                    'display': 'none'
                })
            } else {
                $('#datapick').css({
                    'display': 'none'
                })
                $('#myInput').css({
                    'display': 'block'
                })
            }
        })
        $('#btnOK').on('click', function () {

            if (way == 4) {
                var time1 = $('#datepicker1').val();
                var time2 = $('#datepicker2').val();
                $.ajax({
                    type: "post",
                    url: '/ordershow',
                    data: {
                        way: way,
                        time1: time1,
                        time2: time2,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (a) {
                        if (a == 'space') {
                            alert('日期請勿空白');
                        } else {
                            $('#resaultul').html(a.html);

                        }

                    }
                })
            } else {
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
            }
            //console.log(time1);


        })
    </script>
</body>

</html>