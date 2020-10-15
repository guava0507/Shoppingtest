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
            <a href='/' > xx購物網</a>
        </div>
        <span style="position:absolute;top:10vh;font-size:1vw;">所有訂單</span>
        <div>


            <form id="getorder-form" action="{{url('/getorder')}}" method="POST">
                <table style="position:absolute;top:13vh;border:2px;color:black" border="1">
                    @foreach($orderdata as $orderdatas)
                    <tr>
                        <td>
                            {{ csrf_field() }}
                            <a name="gethref" href="javascript:void(0)">
                                {{$orderdatas->orderId}}
                            </a>
                            <input type="hidden" id="gethref" name="gethref" />
                        </td>
                    </tr>
                    @endforeach
                </table>
            </form>

        </div>
    </div>

    <script>
        $("a").click(function () {
            var gethref = $(this).text();
            $("input[name='gethref']").val(gethref);
            $("#getorder-form").submit();
        })
    </script>
</body>

</html>