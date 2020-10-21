<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <title>Document</title>
</head>
<style>
    .m-b-md {
        position: absolute;
        top: 0px;
        left: 0px;
        margin-bottom: 30px;
    }

    .title {
        font-size: 5vh;
    }
</style>

<body>
    <div class="title m-b-md">
        <a href='/'> xx購物網</a>
    </div>
    @foreach($detail as $prodetail)
    <div style="position:absolute;top:10vh">
        <div style="width:400px;height:300px">
        <img align="left" style="width:100%;height:100%;" src="/image/{{$prodetail->name}}.jpg"/>
        </div>
        <form method="post" action="{{url('/buycar')}}">
            
            {{ csrf_field() }}
            <label>商品名稱:{{$prodetail->name}}</label><br>
            <input type="hidden" id="pname" name="pname" value="{{$prodetail->name}}" />
            <label>價格:{{$prodetail->price}}</label><br>
            <input type="hidden" id="pprice" name="pprice" value="{{$prodetail->price}}" />
            <label>庫存:{{$prodetail->stock}}</label><br>
            <input id="buynum" name="buynum" type="number" value="1" min="1" oninput="if(value<1)value=1"
                max="{{$prodetail->stock}}" /></br>
            <input id="addcar" name="addcar" type="submit" value="加入購物車" />
        </form>
    </div>
    @endforeach
    <a  style="position:absolute;top:50vh;left:40vw" class="btn btn-warning btn-sm"href="/">回首頁</a>
    
</body>

</html>