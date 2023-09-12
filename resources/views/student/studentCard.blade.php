<!DOCTYPE html>
<html>
<head>
  <title>Student Card</title>
  <style type="text/css">
    body{
      padding: 0 !important;
      margin:0;
      background:#fff !important;
    }
    .container{
      width:100%;
    }
    hr{
      border-top: 2px solid #000 !important;
          margin-bottom: 2rem !important;
    }
    .card-box {
    margin-bottom: 0 !important;
    border-radius: .25rem;
    height: 70em;
}
p.card-text {
    margin: 0 13px;
    font-size: 12px;
}
 .bk-txt{
    line-height: 1.2;
    font-size:10px !important;
 }
</style>
<link href="{{asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
        <div class="container">
      <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card" style="width: 204px;height: 324px;border-radius: 11px;border: 0.1px solid #21203bb8;">
                <div class="card-body" style="
    background: linear-gradient(0deg, #0055f1, #080219e3);
    border-radius: 9px 9px 91px 91px;
    height: 8em;
    flex: auto !important;
    padding: inherit !important;
    margin-bottom: 37px;
    ">
<!--                   <img src="{{asset('img/logo_unilak1.jpg')}}" style="
    width: 21%;
    position: absolute;
    margin: auto;
    left: 0;
    right: 0;
    top: 9px;
    "> -->
<h5 class="card-title" style="
    margin: auto;
    position: relative;
    left: 0;
    right: 0;
    text-align: center;
    top: 22px;
    color: aliceblue;
    font-size: 9px;
    ">UNIVERSITY OF LAY ADVENTIST OF KIGALI <br>KIGALI, RWANDA <br><br>STUDENT ID CARD</h5>
                                    </div>
        <img class="rounded-circle" src="{{asset('images')}}/{{$image}}"style="
    width: 42%;
    margin: auto;
    border: 2px solid #fff;
    top: 82px;
    position: absolute;
    left: 0;
    right: 0;
    ">
<div class="card-body" style="
    flex: auto !important;
    padding: inherit !important;
    color: #22203a;
">
        <p class="card-text">Full Name: <b>{{$fullname}}</b></p>
         <p class="card-text">Reg#: <b>{{$reg_num}}</b></p>
           <p class="card-text">Faculty: <b>{{$faculty}}</b></p>
            <p class="card-text">Department: <b>{{$department}}</b></p>
                                    </div>
                                </div>

                            </div>

    <div class="col-md-6 col-xl-3">
            <div class="card" style="width: 204px;height: 324px;border-radius: 11px;border: 0.1px solid #21203bb8;">
                <div class="card-body" style="
border-radius: 9px 9px 91px 91px;
    flex: auto !important;
    padding: inherit !important;
    margin-bottom: 68px;
    ">
                  
<h5 class="card-title" style="
        margin: auto;
    position: relative;
    left: 0;
    right: 0;
    text-align: center;
    top: 13px;
    color: #202241;
    font-size: 14px;
    ">UNILAK</h5>
<img src="{{asset('img/logo_unilak1.jpg')}}" style="
    width:36%;
    position: absolute;
    margin: auto;
    left: 0;
    right: 0;
    top:36px;
    ">
                                    </div>

<div class="card-body" style="
    flex: auto !important;
    padding: inherit !important;
    color: #22203a;    text-align: center;
">
        <p class="card-text bk-txt"><b>If found, please deliver to:</b></p>
         <p class="card-text bk-txt"><b>The University of Lay Adventist of Kigali Campus Kigali, Rwanda</b></p><p></p>
        {!! QrCode::size(100)->generate($qr_code,); !!}
     <!--  </div> --><p></p>
         <p class="card-text bk-txt"><b>Valid Until: Dec. 31, 2024</b></p>
                                    </div>
                                </div>

                            </div>
  </div>
  
</div>
  </body>
</html>