<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> xx購物網等級設定</title>
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
        @section('all')
        <div style="position:absolute;top:10vh" id="all">
            @foreach($level as $lev)
            <span>等級{{$lev->level}}</span><input min="1" type="number" name="inputnum" id="input{{$lev->level}}"
                value="{{$lev->money}}" disabled><br>
            <p></p>
            @endforeach
            <button style="position:absolute;top:35vh" id="btnedit">修改</button>
        </div>
        
        @show
    </div>
  
    <script>
        $('body').on('click', '#btnedit', function () {
            if ($('#btnedit').text() == '修改') {
                $("input[name='inputnum']").prop("disabled", false);
                $('#btnedit').text('完成');


            } else {
                var array = [];
                var x = $('#all').find("input").length;
                for (var i = 1; i <= x; i++) {
                    array[i] = $('#all').find("#input" + i).val();
                }


                $.ajax({
                    method: "post",
                    url: "/levelfinish",
                    data: {
                        x: x,
                        array: array,
                        '_token': '{{csrf_token()}}',
                    },
                    success: function (e) {
                        if (e == 'no') {
                            alert('請勿輸入負數');
                        } 
                        else if(e=='error')
                        {
                            alert('欄位請勿空白');
                        }
                        else{
                            $('#all').html(e.html);
                            // $('#btnedit').text('修改');
                            // $("input[name='inputnum']").prop("disabled", true);
                        }
                        console.log(e);
                    }
                })

            }


            //console.log(array)

        })
    </script>
</body>

</html>