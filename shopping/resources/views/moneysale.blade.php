<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> xx購物網滿額折扣</title>
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
            <span>優惠名稱:</span><input type="text" id="inputname"/>
            <span>輸入達標金額:</span><input type="number" id="inputmoney" />
            <span>輸入折扣:</span><input  type="number" id="inputsale" min='1' max='99' />
            <span>等級限制</span><input type="number" id="inputlevel" min='0' max='5'/>
            <button id="btnOK">確認送出</button>



        </div>
        <script>
            $('#btnOK').click(function () {
                var money = $('#inputmoney').val();
                var sale = $('#inputsale').val();
                var name= $('#inputname').val();
                var level =$('#inputlevel').val();
                $.ajax({
                    method: "post",
                    url: "/inmoneysale",
                    data: {
                        name:name,
                        money: money,
                        sale: sale,
                        level:level,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (e) {
                        console.log(e);
                    }
                })
            })
        </script>
</body>

</html>