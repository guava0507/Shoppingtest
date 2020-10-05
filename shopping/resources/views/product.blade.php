
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    @foreach($detail as $prodetail)
    <div>
    <img align="left" style="width:40%;height:30%;" src="/image/{{$prodetail->name}}.jpg"></img>
  
    <form method="post" action="{{url('/buycar')}}">
    {{ csrf_field() }}
    <label>商品名稱:{{$prodetail->name}}</label><br>
    <input type="hidden" id="pname" name="pname" value="{{$prodetail->name}}" />
    <label">價格:{{$prodetail->price}}</label><br>
    <input type="hidden" id="pprice" name="pprice" value="{{$prodetail->price}}" />
    <label>庫存:{{$prodetail->stock}}</label><br>
    <input id="buynum" name="buynum" type="number" value="1" min="1" oninput="if(value<1)value=1" max="{{$prodetail->stock}}"/></br>
    <input id="addcar" name="addcar" type="submit" value="加入購物車"/>
    </form>

    <script type="text/javascript">
     
    </script>
    </div>
    @endforeach
</body>
</html>