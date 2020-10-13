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
            xx購物網後台
        </div>
        @if($message=Session::get("alert"))
        <h3 class="text-center text-danger">{{$message}}</h3>
        @endif
        <form id="checkform" action={{url('/management')}} method="POST">
            {{ csrf_field() }}
            <span style="position:absolute;top:15vh">請輸入帳號</span><input id="adminaccount" type="text"
                class="form-control" name="adminaccount" style="position:absolute;width:15vw;top:20vh;">
            <span style="position:absolute;top:25vh">請輸入密碼</span><input id="adminpassword" type="password"
                class="form-control" name="adminpassword" style="position:absolute;width:15vw;top:30vh;">
            <button style="position:absolute;top:20vh;left:17vw;" id="sendbtn">確定</button>
        </form>

    </div>


    <script>
        $("#sendbtn").click(function () {
            $("#checkform").submit();


        })
    </script>
</body>

</html>