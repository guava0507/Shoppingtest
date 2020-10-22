<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>所有訂單</title>
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
        <span style="position:absolute;top:10vh;font-size:1vw;">所有訂單</span>
        <div>


            @section('go')
            <div id="change">
                <table style="position:absolute;top:13vh;border:2px;color:black" border="1">
                    <tr>
                        <td>訂單編號</td>
                        <td>訂單狀況</td>
                        <td>操作</td>
                    </tr>
                    @foreach($orderdata as $orderdatas)
                    <tr>
                        <td>
                            <form id="getorder-form" action="{{url('/orderdetail',$orderdatas->orderId)}}">
                                {{ csrf_field() }}
                                <a name="gethref" href="javascript:void(0)">
                                    {{$orderdatas->orderId}}
                                </a>
                            </form>
                            <input type="hidden" id="gethref" name="gethref" />
                        </td>
                        <td id="tdstatus">{{$orderdatas->status}}
                        </td>
                        <td>@if($orderdatas->status=='未出貨')<button id="btngo" class="btn btn-outline-info">出貨</button>
                            @elseif($orderdatas->status=='已出貨')<button id="btngo"
                                class="btn btn-outline-info">取消出貨</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @show
        </div>
    </div>

    <script>
        $('body').on("click",'a',function () {
            var gethref = $(this).text();
            $("input[name='gethref']").val(gethref);
            $("#getorder-form").submit();
        })
        $('body').on('click', '#btngo', function () {
            var b = $(this).text();
            var x = $(this).parent().parent().find('a').text();
            if (b == '出貨') {
                $(this).text('取消出貨');
                $.ajax({
                method: "post",
                url: "/ordergo",
                data: {
                    t: b,
                    x: x,
                    '_token': '{{csrf_token()}}'
                },
                success: function (e) {
                    $('#change').html(e.html);
                    console.log(e);
                }
            })
            } else {
                if (confirm('確定取消出貨嗎')) {
                    $(this).text('出貨');
                    $.ajax({
                method: "post",
                url: "/ordergo",
                data: {
                    t: b,
                    x: x,
                    '_token': '{{csrf_token()}}'
                },
                success: function (e) {
                    $('#change').html(e.html);
                    console.log(e);
                }
            })
                }
                else{
                    $(this).text('取消出貨');
                }
            }
            //var t = $(this).parent().parent().find('#tdstatus').text();
           
          //  var t = $(this).text();
           

        })
    </script>
</body>

</html>