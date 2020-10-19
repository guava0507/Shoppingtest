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
        #back {
            opacity: 0.8;
            width: 100%;
            height: 2000px;
            background: black;
            position: absolute;
            display: none;
            z-index: 1;
        }

        #allform {
            width: 500px;
            height: 500px;
            background: #fff;
            display: none;
            z-index: 2;
            position: absolute;
            left: 50%;
        }

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
        @section('status')
        <table id="tbstatus" style="position:absolute;top:20vh" class="table table-dark">
            <tr>
                <td>產品名稱</td>
                <td>種類</td>
                <td>價格</td>
                <td>庫存</td>
                <td>狀態</td>
                <td>操作</td>
            </tr>
            <div id="divstatus">
                @foreach($products as $product)
                <tr>
                    <td id="tdname">{{$product->name}}</td>
                    <td id="tdcate">{{$product->category}}</td>
                    <td id="tdprice">{{$product->price}}元</td>
                    <td id="tdstock">{{$product->stock}}</td>
                    <input type="hidden" value="{{$product->id}}" id="proid" />
                    <td>{{$product->status}}</td>
                    <td>
                        @if($product->status=='上架')
                        <input id="btnstatus" type="button" class="btn-outline-danger btn-sm btn " value="下架" />
                        @else
                        <input id="btnstatus" type="button" class="btn-outline-danger btn-sm btn " value="上架" />
                        @endif
                        <input type="button" id="btnedit" class="btn-outline-success btn-sm btn" value="修改資料" />
                    </td>
                </tr>
                @endforeach
            </div>
            @show
        </table>
    </div>
    <div id="allform">
        @section('value')
        <form id="useform">
            {{ csrf_field() }}
            <div class="form-group">
                商品名稱:
                <input id="formname" type="text" name="formname" class="form-control">
            </div>
            <div class="form-group">
                種類:
                <select id="chooseval" name="newproduct">
                    @foreach($productype as $values)
                    <option value="{{$values->type}}">{{$values->type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                價格:
                <input oninput="if(value<1)value=1" id="formprice" type="number" class="form-control" name="formprice">
            </div>
            <div class="form-group">
                庫存:
                <input type="number" class="form-control" name="formstock" id="formstock">
            </div>
            <button id="sendOK" type="button" class="btn btn-primary"> 確定送出</button>
            <button id="btncancel" type="button" class="btn btn-secondary">取消</button>
        </form>
        @show
    </div>
    <div id="back"></div>
    <script>
        var id=0;
        var choose = 0;
        var oldname = 0;
        var oldcate = 0;
        $('body').on('click', '#btnstatus', function () {
            var productname = $(this).parents('tr').find("#tdname").html();
            var productstatus = $(this).val();

            //console.log(productstatus);
            // alert($(this).parents('tr').find("#nametd").html());
            $.ajax({
                method: "post",
                url: "/changestatus",
                data: {
                    productname: productname,
                    productstatus: productstatus,
                    '_token': '{{csrf_token()}}',
                },
                success: function (e) {
                    $('#tbstatus').html(e.html);
                    console.log(e);
                }
            })
        })
        $('body').on('click', '#chooseval', function () {
            choose = $(this).val();
            console.log(choose);
        })
        $('body').on('click', '#sendOK', function () {

            var name = $('#formname').val();
            var price = $('#formprice').val();
            var stock = $('#formstock').val();
            var cate = choose;
            $.ajax({
                url: '/proeditOK',
                method: "post",
                data: {
                    id:id,
                    oldname: oldname,
                    name: name,
                    price: price,
                    stock: stock,
                    cate: cate,
                    '_token': '{{csrf_token()}}',
                },
                success: function (e) {
                    console.log(e)
                    if(e=="rename")
                    {
                        alert('產品名已有人使用');
                    }
                    $("#tbstatus").html(e.html);
                    choose = 0;
                    num = 0;
                }
            })
        })
        $('body').on('click', '#btnedit', function () {
            $('#allform').css({
                'display': 'block'
            });
            $('#back').css({
                'display': 'block'
            });
            id=$(this).parent('tr').find("#proid").val();
            var productname = $(this).parents('tr').find("#tdname").html();
            var productcate = $(this).parents('tr').find("#tdcate").html();
            var productprice = $(this).parents('tr').find("#tdprice").html();
            var oldname=$(this).parent('tr').find("#tdname").html();
            productprice = productprice.replace('元', '');
            oldname =$(this).parent('tr').find("#tdname").html();
            var productstock = $(this).parents('tr').find("#tdstock").html();
            $('#formname').val(productname);
            $('#formcate').val(productcate);
            $('#formprice').val(productprice);
            $('#formstock').val(productstock);

            $.ajax({
                method: "post",
                url: "/formshow",
                data: {
                    id:id,
                    productcate: productcate,
                    '_token': '{{csrf_token()}}',
                },
                success: function (e) {
                    $('#useform').html(e.html)
                    $('#formname').val(productname);
                    $('#formprice').val(productprice);
                    $('#formstock').val(productstock);

                    console.log(e);
                }
            })
        })
        $('body').on('click', '#btncancel', function () {

            $('#allform').css({
                'display': 'none'
            });
            $('#back').css({
                'display': 'none'
            });
        })
        $('body').on('click','#typebtn', function () {
                   var c = this.innerHTML;
                   $.ajax({
                       type:"post",
                       url:'/categorychange',
                       data:{cate:c,
                       '_token':'{{csrf_token()}}'},
                       success:function(a){
                           console.log(a);
                          $('#tbstatus').html(a.html);
                       }
                   })
               })
    </script>
</body>

</html>