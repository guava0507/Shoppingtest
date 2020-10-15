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
        <span style="position:absolute;top:10vh;font-size:1vw;">商品種類</span>
        <div>
            <input disabled style="position:absolute;top:9.5%;left:14vw" id="addtext" type="text" />
            <button style="position:absolute;top:10vh;left:5vw;" id="btnadd" class="btn-success">新增</button>
            <button style="position:absolute;top:10vh;left:5vw;display:none" id="btncancel"
                class="btn-success">取消</button>
            @section('change')
            <table id="typetable" style="position:absolute;top:13vh;border:2px;" border="1"
                class="table table-dark table-striped">
                @foreach($type as $types)
                <tr>
                    <td name="producttype" id="producttype">
                        {{$types->type}}
                    </td>
                    <td><input id="btndel" name="btndel" type="button" class="btn-danger" value="刪除" /></td>
                </tr>
                @endforeach
            </table>
            @show
            <button id="btnOK" class="btn-info" style="position: absolute;top:10vh;left:10vw;">確定</button>
        </div>
    </div>

    <script>
        var num = 0;
        $('body').on('click', '#btndel', function () {
            $(this).parent().parent().remove();
        });
        $('#btnadd').click(function () {
            $('#addtext').prop('disabled', false);
            $('#btnadd').css({
                'display': 'none'
            });
            num++;
            $('#btncancel').css({
                'display': 'block'
            });
            $('#btnOK').css({
                'display': 'block'
            })
        })
        $('#btncancel').click(function () {
            $('#addtext').prop('disabled', true);
            $('#addtext').val('');
            $('#btnadd').css({
                'display': 'block'
            });

            $('#btncancel').css({
                'display': 'none'
            });
        })
        $('#btnOK').click(function () {

            var x = $('#addtext').prop("disabled");
            
            $('#btnadd').css({
                'display': 'block'
            });
            $('#addtext').prop('disabled', true);

            $('#btncancel').css({
                'display': 'none'
            });
            
            var typechange = {};
            var addtext = $('#addtext').val();
            $("td[name='producttype']").each(function (index) {
                typechange[index] = $(this).text();
            });
            $.ajax({
                url: '/typechange',
                method: "post",
                data: {
                    x:x,
                    num: num,
                    addtext: addtext,
                    typechange: typechange,
                    '_token': '{{csrf_token()}}'
                },
                success: function (e) {
                    //console.log(e);
                    if (e == 'false') {
                        alert('請勿輸入已有的類別');
                        $('#addtext').val('');
                    } 
                    else if(e=='white')
                    {
                        alert('請勿輸入空白');
                    }
                    else if(e=='nothing')
                    {
                        console.log(e);
                    }
                    else {
                        $('#typetable').html(e.html);
                        $('#addtext').val('');
                    }
                }
            })


        })
    </script>
</body>

</html>