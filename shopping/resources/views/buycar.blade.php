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
      {{ csrf_field() }}
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
      <td name="changename"><input type="checkbox" id="checkdel" name="checkdel" />{{$carlists->proname}}</td>
      <td name="tprice">{{$carlists->proprice}}元</td>
      <td><input name="proquantity" id="proquantity" type="number" value="{{$carlists->quantity}}" style="width:5em"
          oninput="if(value<1)value=1" /></td>

      <td id="totalt" name="totalt">{{$carlists->total}}元</td>

    </tr>
    @endforeach
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td id="ctotal">應付金額:<span id="stotal" name="stotal">{{$carlistt[0]->stotal}}</span>元</td>
    </tr>

  </table>
  @show
  <div style="position:absolute;top:10vh;left:10vw;">
    優惠選擇:
    <select id="selectsale">
      <option value="x">不使用優惠/無優惠/使用購物金</option>
      @foreach($sale1 as $sale1s)
      <option value="{{$sale1s->saleId}}">優惠{{$sale1s->name}}:滿{{$sale1s->money}}打{{$sale1s->sale}}折</option>
      @endforeach
      <option disabled="false">-------------------------------</option>
      @foreach($sale2 as $sale2s)
      <option value="{{$sale2s->saleId}}">優惠{{$sale2s->name}}:滿{{$sale2s->money}}送{{$sale2s->sale}}元購物金</option>
      @endforeach
    </select>
  </div>
  <div style="position: absolute;top:10vh;right:50vw">
    @if($usemoney[0]->total>0)
    <input type="checkbox" id="buymoneycheck" />使用購物金折抵
    @else
    <input type="checkbox" id="buymoneycheck" disabled="true" />沒有購物金可使用
    @endif
  </div>
  <button id="btndelete" name="btndelete" class="btn btn-danger"
    style="position:absolute;top:25vh;right:3vw;">刪除</button>
  <button id="btnall" name="btnall" class="btn btn-warning" style="position:absolute;top:10vh;left:0vw;">全選</button>
  <button id="btnOK" name="btnOK" class="btn btn-success" style="position:absolute;top:10vh;right:3vw;">送出訂單</button>
  <div id="back">
  </div>
  <script>
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

    //選擇優惠
    $('body').on('change', '#selectsale', function () {
      var sale = $('#selectsale').val();

      $.ajax({
        method: "post",
        url: "/buysale",
        data: {
          sale: sale,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          $('#protable').html(e.html)
          console.log(e);

        }
      })
    })
    //購物金使用
    $('body').on('click', '#buymoneycheck', function () {
      var x = $('#buymoneycheck ').prop("checked")
      var sale = $('#selectsale').val();
      if (x) {
        $('#selectsale').prop('disabled', true);
      } else {
        $('#selectsale').prop('disabled', false);
      }
      $.ajax({
        method: "post",
        url: "/usemoney",
        data: {
          x: x,
          sale:sale,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          $('#protable').html(e.html)
          console.log(e)
        }
      })

    })
    //刪除及金額變動
    $("#btndelete").click(function () {
      var allcheck = $(":checkbox:checked");
      var delname = {};
      var delprice = {};

      var deltotal = {};
      allcheck.each(function (e) {
        $(this).parent().parent().remove();
        delname[e] = $(this).parent().text();
        delprice[e] = $(this).parent().parent().find("td").eq(1).text();

      });

      var total = 0;
      $("td[name='totalt']").each(function () {
        total += parseInt($(this).text())
      });

      $.ajax({
        url: '/prolist',
        method: "post",
        data: {
          delprice: delprice,
          delname: delname,
          list: total,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          //  console.log(e);
          if (e != 'nothing') {
            $('#protable').html(e.html)
          }
        }
      })
    });
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

    //完成訂單 產生訂單
    $('#sendOK').click(function () {
      var check = {};
      var getquantity = {};
      var box = $('#buymoneycheck ').prop("checked")
      $("input[name='proquantity']").each(function (index) {

        getquantity[index] = $(this).val();
      })
      var getaddress = $('#getaddress').val();
      var getname = $('#getname').val();
      var total = $('#stotal').text();
      var sale = $('#selectsale :selected').text();
      $("input[name='proquantity']").each(function (index) {

        check[index] = parseInt($(this).val());
      });

      $.ajax({
        url: '/send',
        method: "post",
        data: {
          box:box,
          sale: sale,
          total: total,
          getquantity: getquantity,
          getaddress: getaddress,
          getname: getname,
          '_token': '{{csrf_token()}}'
        },
        success: function (e) {
          if (e == 'space') {
            alert('請勿空白');
          } else {
            $('#protable').html(e.html);
            alert('訂單成立！');
            $('#allform').css({
              'display': 'none'
            });
            $('#getaddress').val('');
            $('#getname').val('');
            $('#back').css({
              'display': 'none'
            });


          }
          console.log(e);


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