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
            xx購物網後台
        </div>
        <div style="position:absolute;top:10vh">
            <div id="categorybtn" class="btn-group" role="group" aria-label="Basic example">
                @foreach($productype as $type)
                <button id="typebtn" type="button" class="btn btn-secondary">{{$type->type}}</button>
                @endforeach
            </div>
        </div>
        @section('product')
        <table style="position:absolute;top:20vh"class="table table-dark">
        <tr>
            <td>產品名稱</td>  
            <td>價格</td>  
            <td>庫存</td>  
            <td>狀態</td>
            <td>操作</td>
        <tr>
        @foreach($products as $product)
      <tr>
            <td>{{$product->name}}</td>
            <td>{{$product->price}}元</td>
            <td>{{$product->stock}}</td>
            <td></td>
            <td></td>
    <tr>
         @endforeach
    </table>
         @show

    </div>
    <script>



    </script>
</body>

</html>