<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂單明細</title>
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
            xx購物網
        </div>

        <div>
            <span style="position:absolute;top:10vh">訂單內容</span><span
                style="position:absolute;top:10%;left:5%">收件人:{{$ordershow[0]->name}}</span>
            <table style="position:absolute;top:13vh;border:2px;" class="table table-dark">
                <tr>
                    <td>產品名稱:</td>
                    <td>單項金額:</td>
                    <td>數量</td>
                    <td>單項小計:</td>
                </tr>
                @foreach($ordershow as $ordershows)
                <tr>
                    <td>{{$ordershows->proname}}</td>
                    <td>{{$ordershows->price}}</td>
                    <td>{{$ordershows->quantity}}</td>
                    <td>{{$ordershows->total}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>出貨狀況:{{$ordertotal[1]->stotal}}</td>
                    <td></td>
                    <td>地址:{{$ordershow[0]->address}}</td>
                    <td>應付金額:{{$ordertotal[0]->stotal}}元<span></td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>