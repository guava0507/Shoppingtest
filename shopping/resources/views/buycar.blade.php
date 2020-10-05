<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>我是購物車</title>
</head>
<body>
<table class="table table-dark">
<thead>
<tr>
<td>產品名稱:</td>
<td>單項:</td>
<td>總共:</td>
<td>應付金額:</td>
</tf>
</thead>
@foreach ($carlist as $carlists )
<tr>
<td>{{$carlists->proname}}</td>
<td>{{$carlists->proprice}}</td>
<td>{{$carlists->total}}</td>
<td>{{$carlistt}}</td>
</tr>
@endforeach

</body>
</html>
