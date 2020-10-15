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
</head>

<body>
  <div class="title m-b-md">
    <a href='/'> xx購物網</a>
  </div>
  <div id="allform">
    <form id="useform">
      <div class="form-group">
        收件人:
        <input type="text" name="getname" class="form-control" id="getname">
      </div>
      <div class="form-group">
        地址:
        <input type="text" class="form-control" name="getaddress" id="getaddress">
      </div>
      <button id="sendOK" type="button" class="btn btn-primary"> 確定送出</button>
      <button id="btncancel" type="button" class="btn btn-secondary">取消</button>
    </form>
  </div>
  @section('clear')
  <table style="position:absolute;top:15vh;" class="table table-dark" id="protable">
    <tr>
      <td>產品名稱:</td>
      <td>單項金額:</td>
      <td>數量</td>
      <td>總共:</td>
    </tr>

    @foreach ($carlist as $carlists )
    <tr>
      <td name="changename"><input type="checkbox" id="checkdel" name="checkdel"
          style="display:none;" />{{$carlists->proname}}</td>
      <td name="tprice">{{$carlists->proprice}}元</td>
      <td><input name="proquantity" id="proquantity" type="number" value="{{$carlists->quantity}}" style="width:5em"
          oninput="if(value<1)value=1" disabled /></td>

      <td id="totalt" name="totalt">{{$carlists->total}}元</td>

    </tr>
    @endforeach
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td id="ctotal"><span id="stotal" name="stotal">應付金額:{{$carlistt[0]->stotal}}元<span></td>
    </tr>

  </table>
  @show


  <button id="proedit" name="proedit" class="btn btn-info" style="position:absolute;top:15vh;right:3vw;">修改商品</button>
  <button id="profinish" name="profinish" class="btn btn-success"
    style="display:none;position:absolute;top:20vh;right:3vw;">修改完成</button>
  <button id="btndelete" name="btndelete" class="btn btn-danger"
    style="display:none;position:absolute;top:25vh;right:3vw;">刪除</button>
  <button id="btnall" name="btnall" class="btn btn-warning"
    style="display:none;position:absolute;top:10vh;left:0vw;">全選</button>
  <button id="btnOK" name="btnOK" class="btn btn-success" style="position:absolute;top:10vh;right:3vw;">送出訂單</button>
  <div id="back">
  </div>
  <script>
    $("#proedit").on("click", function () {
      $("#proedit").prop('disabled', true),
        $("input[name='proquantity']").prop('disabled', false),
        $("input[name='checkdel']").css({
          'display': 'block'
        }),
        $("#profinish").css({
          'display': 'block'
        }),
        $("#btndelete").css({
          'display': 'block'
        }),
        $("#btnall").css({
          'display': 'block'
        });
      $("#btnOK").css({
        'display': 'none'
      })
    })


    //全選
    $("#btnall").click(function () {
      var all = $(":checkbox");
      all.each(function () {
        this.checked = !this.checked;
      })
    })
    var tmpquantity = {};
    $("input[name='proquantity']").each(function (index) {
      tmpquantity[index] = parseInt($(this).val());
    })
    //數量變動 金額變動
    $("input[name='proquantity']").on('change', function () {
      var changeq = {};
      var price = {};
      var proname = {};
      $("td[name='changename']").each(function (index) {
        proname[index] = ($(this).text());
      })
      $("td[name='tprice']").each(function (index) {
        price[index] = parseInt($(this).text());
      });
      $("input[name='proquantity']").each(function (index) {

        changeq[index] = parseInt($(this).val());
      });

      var total = 0;
      $.ajax({
        url: '/qchange',
        method: "post",
        data: {
          changeq: changeq,
          price: price,
          proname: proname,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          if (typeof (e) == 'string') {
            alert(e);
            $("input[name='proquantity']").each(function (index) {
              parseInt($(this).val(tmpquantity[index]))
            })
          } else {
            console.log(e);
            $("td[name='totalt']").each(function (index) {
              parseInt($(this).text(e[index] + "元"))
              total += e[index];
            })
            $("#stotal").text(total + "元");
          }
        }
      })
    })
    //刪除及金額變動
    $("#btndelete").click(function () {
      var allcheck = $(":checkbox:checked");
      allcheck.each(function () {
        $(this).parent().parent().remove();
      });

      var total = 0;
      $("td[name='totalt']").each(function () {
        total += parseInt($(this).text())
      });

      $.ajax({
        url: '/prolist',
        method: "post",
        data: {
          list: total,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          console.log(e);
          $('#stotal').text(e);
        }
      })
    });


    //修改完成
    $("#profinish").click(function () {
      var changeq = {};
      var changename = {};
      var price = {};

      $("td[name='tprice']").each(function (index) {
        price[index] = parseInt($(this).text());
      });
      $("td[name='changename']").each(function (index) {
        changename[index] = $(this).text();
      });
      $("input[name='proquantity']").each(function (index) {

        changeq[index] = parseInt($(this).val());
      });
      if (price == "") {
        changename = 0;
        price = 0;
        changeq = 0;
      }
      $.ajax({
        url: '/editfinish',
        method: "post",
        data: {
          changeq: changeq,
          changename: changename,
          price: price,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          $("input[name='proquantity']").prop('disabled', true),
            $("input[name='checkdel']").css({
              'display': 'none'
            }),
            $("#profinish").css({
              'display': 'none'
            }),
            $("#btndelete").css({
              'display': 'none'
            }),
            $("#btnall").css({
              'display': 'none'
            });
          $("#proedit").prop('disabled', false);
          $("#btnOK").css({
            'display': 'block'
          })
        }
      })
    })

    //送出訂單
    $("#btnOK").on('click', function () {
      var check = {};
      $("input[name='proquantity']").each(function (index) {

        check[index] = parseInt($(this).val());
      });
      console.log(check[0]);
      if (check[0] == undefined) {
        alert('請先加入商品');
        window.location.href = '/';
      } else {
        $('#allform').css({
          'display': 'block'
        });
        $('#back').css({
          'display': 'block'
        });

      }


    })
    $('#sendOK').click(function () {
      var check = {};
      var getaddress = $('#getaddress').val();
      var getname = $('#getname').val();
      $("input[name='proquantity']").each(function (index) {

        check[index] = parseInt($(this).val());
      });

      $.ajax({
        url: '/send',
        method: "post",
        data: {
          getaddress: getaddress,
          getname: getname,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {

       
            console.log(e);
            //alert('訂單成立！');
            $('#protable').html(e.html);
            $('#allform').css({
              'display': 'none'
            });
            $('#getaddress').val('');
            $('#getname').val('');
            $('#back').css({
              'display': 'none'
            });
          
        }
      })
    })
    $('#btncancel').click(function () {
      $('#allform').css({
        'display': 'none'
      });
      $('#getaddress').val('');
      $('#getname').val('');
      $('#back').css({
        'display': 'none'
      });
    })
  </script>
</body>

</html>