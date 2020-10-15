<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>xx購物網</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {

                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;

            }

            .full-height {
                height: 100vh;
            }


            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 5vh;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                position:absolute;
                top:0px;
                left:0px;
                margin-bottom: 30px;
            }
            .hov{
                position:absolute;
                top:70px;
                left:0px;
                margin-left:15px;
            }
           
        </style>
    </head>
    <body>
        <div class=" position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">會員中心</a>
                    @else
                        <a href="{{ route('login') }}">登入</a>
                        <a href="{{ route('register') }}">註冊</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                  <a href='/' > xx購物網</a>
                </div>

                <div id="categorybtn" class="btn-group" role="group" aria-label="Basic example">
                @foreach($productype as $type)
                <button id="typebtn" type="button" class="btn btn-secondary">{{$type->type}}</button>
               @endforeach
               </div>

               <div>
              <a href="{{url('/buycar')}}" style="position:absolute;right:0px;top:40px;" class="btn btn-warning" >購物車</a>
               </div>


                <select id="productsort" name="productsort">
                <option value="" disabled selected hidden>排列方式</option>
               <option value="1" >最新排序</option>
               <option value="2">價格排序</option>
               <option value="3">字首排序</option>
               </select>
                <script type="text/javascript">
                $('body').on('change','#productsort', function () {
                   var x=$(this).val();
                    $.ajax({
                        type:"post",
                        url: '/prosort',
                        data:{prosort:x,
                            '_token':'{{csrf_token()}}'},
                        success:function(e){
                            console.log(e);
                            $('.row').html(e.html);
                        }
                    })
               });
               $('body').on('click','#typebtn', function () {
                   var c = this.innerHTML;
                   $.ajax({
                       type:"post",
                       url:'/category',
                       data:{cate:c,
                       '_token':'{{csrf_token()}}'},
                       success:function(a){
                           console.log(a);
                          $('.row').html(a.html);
                       }
                   })
               })
              
                </script>

                <div class ="row" style="position:absolute;top:30vh">
               @section('product')
               @foreach($products as $product)
               <div style="float:left;margin:3vw;width:100vw;height:30vh;background-color:#EFFFD7" class= "col-3">
               <a href={{url('/productd',$product->name)}}><img style="width:50%;height:50%" src="/image/{{$product->name}}.jpg"/></a>
               <span>產品名稱:{{$product->name}}</span><br>
               <span>價格:{{$product->price}}元</span><br>
               <span>庫存:{{$product->stock}}</span>
               </div>
                @endforeach
                @show
            </div>

    </body>
</html>
