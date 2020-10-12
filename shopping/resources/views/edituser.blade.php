<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
        <div id="checkdiv">
            <span id="checkpass" style="position:absolute;top:15vh">請輸入密碼</span><input id="password" type="password"
                class="form-control" name="password" style="position:absolute;width:15vw;top:20vh;">
            <button style="position:absolute;top:20vh;left:17vw;" id="sendbtn">確定</button>
        </div>
        <div id="choosediv" class="btn-group" style="display:none" role="group">
            <span style="position:absolute;top:20vh;">請選擇要修改的項目:</span>
            <button class="btn" style="position:absolute;top:25vh" id="pass">密碼</button>
            <button class="btn" style="position:absolute;top:30vh" id="other">信箱、地址</button>
        </div>

        @foreach($userdata as $editdata)
        <div id="alldiv">
        <div id="otherdiv" style="display:none">
            <span style="position:absolute;top:30vh">信箱</span><input id="nemail" type="text" name="email" class="form-control"
                value="{{$editdata->email}}" style="position:absolute;left:7vw;width:15vw;top:30vh;">
            <span style="position:absolute;top:35vh">地址</span><input id="naddress" type="text" name="address" class="form-control"
                value="{{$editdata->address}}" style="position:absolute;left:7vw;width:15vw;top:35vh;">
        </div>
        <div id="passdiv" style="display:none">
            <span style="position:absolute;top:20vh;">新密碼</span><input id="newpass" type="password" name="pass" class="form-control"
                style="position:absolute;left:7vw;width:15vw;top:20vh;">
            <span style="position:absolute;top:25vh;">再輸入一次</span><input id="agpass" type="password"
                class="form-control" name="agpass" style="position:absolute;left:7vw;width:15vw;top:25vh;">
        </div>
    </div>
        
        @endforeach

        <button style="position:absolute;top:20vh;left:22vw;top:40vh;display:none;" id="btnedit">確認修改</button>
    </div>
    </div>
    <script>
        var showc=0
         var passc =0;
         var emailc=0;
         var addressc=0;
         var apassc=0;
        $('#sendbtn').on('click', function () {
            var send = $("#password").val();
            $.ajax({
                method: "post",
                url: '/passcheck',
                data: {
                    send: send,
                    '_token': '{{csrf_token()}}'
                },
                success: function (e) {
                    if (e == 'X') {
                        alert('請輸入正確的密碼！');
                    } else {
                        $("#checkdiv").css({
                            'display': 'none'
                        })
                        $("#choosediv").css({
                            'display': 'block'
                        })

                    }
                }
            })
        })

        $("#choosediv > button.btn").on("click", function () {
          showc = $(this).attr('id');
            $("#btnedit").css({
                'display': 'block'
            });
            switch (showc) {
                case 'pass':
                    $('#passdiv').css({
                        'display': 'block'
                    })
                    $('#choosediv').css({
                        'display': 'none'
                    })
                    break;
                case 'other':
                    $('#otherdiv').css({
                        'display': 'block'
                    })
                    $('#choosediv').css({
                        'display': 'none'
                    })
                    break;
           
            }

            //console.log(c)
        })
        $("#btnedit").click(function(){
            //var checkc = $("input[name="+c+"]").val();
            //var chechac=$("input[name='agpass']").val();
            if(showc=='pass')
            {
                passc=$("input[name='pass']").val();
                apassc=$("input[name='agpass']").val();
                $.ajax({
                method: "post",
                url: '/useredit',
                data: {
                  newpass : passc,
                  agpass:apassc,
                    '_token': '{{csrf_token()}}'
                },
                success:function(e){
                    if(e=='re')
                    {
                        alert('請輸入正確的密碼');
                    }
                    else
                    {
                        alert("修改完成！")
                        $("#checkdiv").css({'display':'none'});
                        $("#passdiv").css({'display':'none'});
                        $("#alldiv").css({'display':'block'});
                        $("#choosediv").css({'display':'block'})
                        $('#btnedit').css({'display':'none'})
                        $('#newpass').val('');
                        $('#agpass').val('');
                    }
                    console.log(e)
                }
            })
            }
            else{
                addressc=$("input[name='address']").val();
                emailc=$("input[name='email']").val();
                $.ajax({
                method: "post",
                url: '/useredit',
                data: {
                  address : addressc,
                  email:emailc,
                    '_token': '{{csrf_token()}}'
                },
                success:function(e){
                    if(e=='re')
                    {
                        alert('請輸入正確的資料');
                    }
                    else if(e=='重複')
                    {
                        alert('信箱已經有人使用');
                    }
                    else
                    {
                        alert("修改完成！")
                        $("#checkdiv").css({'display':'none'});
                        $("#otherdiv").css({'display':'none'});
                        $("#alldiv").css({'display':'block'});
                        $("#choosediv").css({'display':'block'})
                        $('#btnedit').css({'display':'none'})
                       
                    }
                    console.log(e)
                }
            })
            }
           
        })
    </script>
</body>

</html>