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
            xx購物網
        </div>
        <span style="position:absolute;top:10vh;font-size:1vw;">所有優惠</span>

        <span style="position:absolute;top:20vh;font-size:1vw;">滿額贈購物金:</span>
        <span style="position:absolute;top:20vh;left:40vw;font-size:1vw;">滿額折扣:</span>
        @section('table')
        <div id="all">
            <table id="table1" style="position:absolute;top:25vh;border:2px;color:black" border="1">
                <tr>
                    <td>優惠名稱</td>
                    <td>優惠內容</td>
                    <td>等級限制</td>
                    <td>操作</td>
                </tr>
                @foreach($money as $moneyshow)
                <tr>
                    <input type="hidden" name="saleId" value="{{$moneyshow->saleId}}" />
                    <input type="hidden" name="saletype" value="{{$moneyshow->type}}" />

                    <td><input name="salename" value="{{$moneyshow->name}}" style="width:7vw" disabled /> </td>
                    <td>滿<input name="money" id="money" type="number" style="width:7vw" value="{{$moneyshow->money}}"
                            disabled />贈<input name="sale" id="sale" type="number" style="width:7vw"
                            value="{{$moneyshow->sale}}" disabled />購物金</td>
                    <td><input name="salelevel" type="number" min="1" max="5" value="{{$moneyshow->level}}" disabled />
                    </td>

                    <td><button id="btnedit" class="btn btn-outline-success btn-sm">修改</button><button id="btndel"
                            class="btn btn-outline-danger btn-sm">刪除</button></td>
                    </td>

                </tr>
                @endforeach
            </table>
            <table id="table2" style="position:absolute;left:40vw;top:25vh;border:2px;color:black" border="1">
                <tr>
                    <td>優惠名稱</td>
                    <td>優惠內容</td>
                    <td>等級限制</td>
                    <td>操作</td>
                </tr>
                @foreach($sale as $saleshow)
                <tr>
                    <input type="hidden" name="saleId" value="{{$saleshow->saleId}}" />
                    <input type="hidden" name="saletype" value="{{$saleshow->type}}" />
                    <td><input name="salename" value="{{$saleshow->name}}" style="width:7vw" disabled /> </td>
                    <td>滿<input min="1" name="money" id="money" type="number" style="width:7vw"
                            value="{{$saleshow->money}}" disabled />打<input min="1" max="99" name="sale" id="sale"
                            type="number" style="width:7vw" value="{{$saleshow->sale}}" disabled />折</td>
                    <td><input name="salelevel" type="number" min="1" max="5" value="{{$saleshow->level}}" disabled />
                    </td>
                    <td><button id="btnedit" class="btn btn-outline-success btn-sm">修改</button><button id="btndel"
                            class="btn btn-outline-danger btn-sm">刪除</button></td>
                </tr>
                @endforeach
            </table>
        </div>
        @show



    </div>

    <script>
        $('body').on('click', '#btnedit', function () {
            if ($(this).text() == '完成') {
                var name = $(this).parent().parent().find("input[name='salename']").val();
                var money = $(this).parent().parent().find("input[name='money']").val();
                var sale = $(this).parent().parent().find("input[name='sale']").val();
                var id = $(this).parent().parent().find("input[name='saleId']").val();
                var level = $(this).parent().parent().find("input[name='salelevel']").val();
                // console.log(sale);
                $.ajax({
                    method: "post",
                    url: "/saleedit",
                    data: {
                        type: type,
                        id: id,
                        name: name,
                        money: money,
                        sale: sale,
                        level: level,
                        '_token': '{{csrf_token()}}',
                    },
                    success: function (e) {
                        if (e == "rename") {
                            alert("在這個優惠類別，此優惠名稱已有人使用");
                            $(this).parent().parent().find('input').prop("disabled", true);
                            $(this).text('完成');
                        } else {
                            $('#all').html(e.html);
                        }
                        console.log(e);
                    }
                })
            } else {
                $(this).parent().parent().find('input').prop("disabled", false);
                $(this).text('完成');
            }
        })
        $('body').on('click', '#btndel', function () {
            if (confirm('確定要刪除嗎')) {
                var id = $(this).parent().parent().find("input[name='saleId']").val();
                $.ajax({
                    method: "post",
                    url: "/saledel",
                    data: {
                        id: id,
                        '_token': '{{csrf_token()}}',
                    },
                    success: function (e) {
                        $('#all').html(e.html);
                        console.log(e);
                    }
                })
            }
        })
    </script>
</body>

</html>