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
        <div style="position:absolute;top:10vh">
        <form id ="usermanage" method="post" action="{{url('/usermanage')}}">
            {{ csrf_field() }}
            <button type=submit id="usermanage">帳號管理</button>
            </form>
            <button id="ordersearch">訂單查詢</button>

        </div>

    </div>
    <script>
//  $("#usermanage").click(function(){
//      $("#usermanage").submit();
//      $.ajax({
//          method:"post",
//          url:"/usermanage"
//          data:{
//             '_token': '{{csrf_token()}}',
//          },
//          success:function(e){
//              console.log(e);
//          }     
//          })
//  })
    </script>
</body>

</html>