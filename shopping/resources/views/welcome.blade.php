<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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
            .row{

            }
        </style>
    </head>
    <body>
        <div class=" position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                   xx購物網
                </div>

                <div class="links hov">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                
                <select id="productsort">
               <option value="1" >最新排序</option>
               <option value="2" selected>價格排序</option>
               <option value="3">字首排序</option>
               </select>
                <script type="text/javascript">
               $('#productsort').on('change',function(){
                   var x=$('#productsort option:selected').attr('value');
                    $.ajax({
                        type:"GET",
                        url: "/",
                        data:{ prosort:x },
                        success:function(e){
                            console.log('good!'+e);
                        }
                    })
               });
                </script>

                <div class ="row" style="position:absolute;top:30vh">
               @foreach($products as $product)
               <div style="float:left;margin:1.3vw;width:30vw;height:30vh;background-color:#EFFFD7" class= "col-3">
               <span>產品名稱:{{$product->name}}</span><br>
               <span>價格:{{$product->price}}元</span><br>
               <span>庫存:{{$product->stock}}</span>
               </div>
                @endforeach
            </div>

    </body>
</html>
