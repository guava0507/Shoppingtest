<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> xx購物網上架商品</title>
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
            xx購物網新增商品
        </div>
        <div style="position:absolute;top:10vh">
            @section('clear')
            <form id="addform" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <span>商品名稱:</span>
                    <input type="text" class="form-control" id="productid" name="productid" />
                </div>
                <div class="form-group">
                    <span>價格:</span>
                    <input type="number" class="form-control" id="productprice" name="productprice"
                        oninput="if(value<1)value=1" />
                </div>
                <div class="form-group">
                    <span>數量:</span>
                    <input type="number" class="form-control" id="productquantity" name="productquantity"
                        oninput="if(value<0)value=0" style="width:80px;" max="999" />
                </div>
                <div class="form-group">
                    <select id="chooseval" name="newproduct">
                        @foreach($productval as $values)
                        <option value="{{$values->type}}">{{$values->type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span>圖片:</span>
                    <input type="file" name="file" id="file" onchange="showImg(this)" />
                    <img id="showimg" src="" style="display:none;width:40%;height:30%" />
                </div>
                <button id="addbtn" type="button" class="btn btn-primary">確認新增</button>
            </form>
            @show
        </div>
    </div>
    <script>
        $("#addbtn").click(function () {
            console.log("?");
            var form = new FormData(document.getElementById('addform'));
            var file = document.getElementById('file').files[0];
            if (file) {
                form.append('file', file);
                console.log(file);
            }
            console.log(form);
            $.ajax({
                type: "post",
                url: '/addfinish',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function (e) {
                    if (e == 'rename') {
                        alert('此商品已存在,請重新輸入名稱');
                    } else if (e == 'space') {
                        alert('欄位請勿空白');
                    } else {
                        alert('新增成功');
                        $('#addform').trigger("reset");
                        showimg.style.display='none';
                        console.log(e);
                    }

                }
            })
        })

        function showImg(test) {
            var file = test.files[0];
            if (window.FileReader) {
                var fr = new FileReader();
                var showimg = document.getElementById('showimg');
                fr.onloadend = function (e) {
                    showimg.src = e.target.result;
                };
                fr.readAsDataURL(file);
                showimg.style.display = 'block';
            }
        }
    </script>
</body>

</html>