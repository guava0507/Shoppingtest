<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> xx購物網優惠活動</title>
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
            xx購物網優惠活動
        </div>
        <div style="position:absolute;top:10vh">
            <form method="post" action="{{url('/moneysale')}}">
                {{ csrf_field() }}
                <button type="submit" id="usermanage">滿額折扣</button>
            </form>
            <form method="post" action="{{url('/moneyfree')}}">
                {{ csrf_field() }}
                <button type="submit">滿額贈購物金</button>
            </form>
            <form id="salelistform" method="post" action="{{url('/salelist')}}">
                {{ csrf_field() }}
                <button type="submit" id="salelist">優惠列表</button>
            </form>
            <form id="levelform" method="post" action="{{url('/levelset')}}">
                {{ csrf_field() }}
                <button type="submit" id="levelset">等級設定</button>
            </form>

        </div>

    </div>
</body>

</html>