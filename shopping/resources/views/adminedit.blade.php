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
    <div class="content">
        <div style="height:10vh;" class="title m-b-md">
            xx購物網帳號管理
        </div>

        <div id="userdiv" style="position:absolute;top:20vh;width:30vw;font-size:20px;">
            <button id="btnedit" class="btn btn-info">修改</button>
            <button id="btnOK" class="btn btn-success" style="display:none">完成</button>

            @section('form')
            <form id="dataform">

                {{ csrf_field() }}
                <fieldset id="formlock" disabled>
                    @foreach($userdata as $data)
                    <span>使用者名稱:</span><input name="usname" id="usname"
                        style="position: absolute;left:10vw;margin-bottom:3px" type="text"
                        value="{{$data->name}}" /><br>
                    <span>密碼</span><input name="uspassword " id="uspassword" type="password"
                        style="position:absolute;left:10vw;margin-bottom:3px" value="********" /><br>

                    <span>身分證:</span><input name="usidentcard" id="usidentcard"
                        style="position: absolute;left:10vw;margin-bottom:3px" pattern="^[A-Z]\d{9}$" type="text"
                        value="{{$data->identcard}}" /><br>

                    <span>信箱:</span><input name="usemail" id="usemail"
                        style="position: absolute;left:10vw;margin-bottom:3px" pattern="\w+([.-]\w+)*@\w+([.-]\w+)+"
                        type="text" value="{{$data->email}}" /><br>

                    <span>地址:</span><input name="usaddress" id="usaddress"
                        style="position: absolute;left:10vw;margin-bottom:3px" pattern="^[\u4E00-\u9FA5-a-zA-Z0-9]+$"
                        type="text" value="{{$data->address}}" /><br>
                    <input name="usId" id='usId' type="hidden" value="{{$data->id}}"    />
                    <span>電話:</span><input name="usphone" id="usphone"
                        style="position: absolute;left:10vw;margin-bottom:3px" pattern="09[0-9]{8}$" type="text"
                        value="{{$data->phone}}" />
                    @endforeach
                </fieldset>

            </form>
            @show
        </div>


    </div>
    <script>
        var oldname=$('#usname').val();
        $("#btnedit").click(function () {
            $('#formlock').prop('disabled', false);
            $('#btnOK').css({
                'display': 'block'
            });
            $('#btnedit').css({
                'display': 'none'
            })
        })
        $('#btnOK').click(function () {

            var namech = $('#usname').val();
            var passwordch = $('#uspassword').val();
            var identch = $('#usidentcard').val();
            var emailch = $('#usemail').val();
            var addressch = $('#usaddress').val();
            var phonech = $('#usphone').val();
            
            var id=$('#usId').val();
            if (passwordch == "********") {
                $.ajax({
                    method: "post",
                    url: "/userdatach",
                    data: {
                        id:id,
                        oldname:oldname,
                        namech: namech,
                        identch: identch,
                        emailch: emailch,
                        addressch: addressch,
                        phonech: phonech,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (e) {
                        console.log(e);
                        switch (e) {
                            case 'identused':
                                alert('身分證已使用');
                                break;

                            case 'emailused':
                                alert('信箱已使用');
                                break;
                        }
                        $("#datafrom").html(e.html);
                        $('#formlock').prop('disabled', true);
                        $('#btnOK').css({
                            'display': 'none'
                        });
                        $('#btnedit').css({
                            'display': 'block'
                        });
                    }
                })
            } else {
                $.ajax({
                    method: "post",
                    url: "/userdatach",
                    data: {
                        oldname:oldname,
                        namech: namech,
                        identch: identch,
                        addressch: addressch,
                        phonech: phonech,
                        passwordch: passwordch,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (e) {
                        console.log(e);
                        switch (e) {
                            case 'identused':
                                alert('身分證已使用');
                                break;

                            case 'emailused':
                                alert('信箱已使用');
                                break;
                        }
                        $("#datafrom").html(e.html);
                        $('#formlock').prop('disabled', true);
                        $('#btnOK').css({
                            'display': 'none'
                        });
                        $('#btnedit').css({
                            'display': 'block'
                        });
                    }
                })
            }

        })
    </script>
</body>

</html>