@extends('layouts.default')

@section('title')
Record Attendance
@endsection('title')
@section('content')
<style type="text/css">
    .btn-group-sm>.btn, .btn-sm {
    padding: 3px 6px;
    font-size: .7875rem;
    line-height: 1.5;
    border-radius: .15rem;
}
    table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 8px !important;
}
#preview{
   width:400px;
   /*height: 500px;*/
   margin:0px auto;
}
</style>
<script src="{!! asset('jquery-3.4.1.js') !!}"></script> 

<!-- <link href="{!! asset('bootstrap.min.css') !!}" rel="stylesheet"> -->

<link  href="{!! asset('jquery.dataTables.min.css') !!}" rel="stylesheet">

<script src="{!! asset('jquery.dataTables.min.js') !!}"></script>

<script src="{!! asset('jquery.validate.js') !!}"></script>

<script src="{!! asset('bootstrap.min.js') !!}"></script>
   
 <div class="container">
 <div class="row">
                    <div class="col-md-12" style="justify-content: center;text-align: center;">

<!-- <video id="preview"></video> -->
<div id="qr-reader" style="width: 600px"></div>
<!-- <script src="{{ asset('instascan.min.js') }}">

</script> -->
<!-- include the library -->
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
                    </div>
                </div><br>
    <table class="table table-bordered table-responsive" id="attendance_table" width="100%" style="display: inline-table;">
           <thead>
            <tr>
                     <th>Image</th>
                     <th>Reg Number</th>
                     <th>First Name</th>
                     <th>Last Name</th>
                     <th>Course</th> 
                     <th>Date & Time</th> 
            </tr>
           </thead>
       </table>
   </div>


<script>
    function onScanSuccess(decodedText, decodedResult) {
    //console.log(`Code scanned = ${decodedText}`, decodedResult);
    window.location.href=decodedText;
}
var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
    // var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
    // scanner.addListener('scan',function(content){
    //     //alert(content);
    //     window.location.href=content;
    // });
    // Instascan.Camera.getCameras().then(function (cameras){
    //     if(cameras.length>0){
    //         scanner.start(cameras[0]);
    //         $('[name="options"]').on('change',function(){
    //             if($(this).val()==1){
    //                 if(cameras[0]!=""){
    //                     scanner.start(cameras[0]);
    //                 }else{
    //                     alert('No Front camera found!');
    //                 }
    //             }else if($(this).val()==2){
    //                 if(cameras[1]!=""){
    //                     scanner.start(cameras[1]);
    //                 }else{
    //                     alert('No Back camera found!');
    //                 }
    //             }
    //         });
    //     }else{
    //         console.error('No cameras found.');
    //         alert('No cameras found.');
    //     }
    // }).catch(function(e){
    //     console.error(e);
    //     alert(e);
    // });
$(document).ready(function(){
var currentURL = window.location.href;
    var param = currentURL.split('/');
    var course_id = param[6];
 $('#attendance_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ URL::to('/record-course-attendance') }}/"+course_id,
  },
  columns:[
  {
    data: 'image',
    name: 'image',
    render: function (data, type, full, meta) {
        return "<img src=\"{{asset('images')}}\\" + data + "\" height=\"50\"/>";
    },
   },
   {
    data: 'reg_num',
    name: 'reg_num'
   },
   {
    data: 'first_name',
    name: 'first_name'
   },
   {
    data: 'last_name',
    name: 'last_name'
   },
   {
    data: 'course',
    name: 'course'
   },
   {
    data: 'student_presence_datetime',
    name: 'student_presence_datetime',
   },
  ]

});
});
</script>
 @endsection('content')