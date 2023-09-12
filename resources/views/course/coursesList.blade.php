@extends('layouts.default')

@section('title')
Students List
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
</style>
<script src="{!! asset('jquery-3.4.1.js') !!}"></script> 

<!-- <link href="{!! asset('bootstrap.min.css') !!}" rel="stylesheet"> -->

<link  href="{!! asset('jquery.dataTables.min.css') !!}" rel="stylesheet">

<script src="{!! asset('jquery.dataTables.min.js') !!}"></script>

<script src="{!! asset('jquery.validate.js') !!}"></script>

<script src="{!! asset('bootstrap.min.js') !!}"></script>
   
 <div class="container">
 <div class="row">
                    <div class="col-md-12">
                        <div class="dt-buttons">
                            <a class="dt-button buttons-print btn dark btn-outline" style="background-color: #035594;" tabindex="0" aria-controls="sample_1" href="{{route('add-course')}}">
                                <span><i class="fa fa-plus"></i> Add New Coursee</span>
                            </a>
                        </div>
                    </div>
                </div><br>
    <table class="table table-bordered table-responsive" id="courses_table" width="100%" style="display: inline-table;">
           <thead>
            <tr>
                     <th>ID</th>
                     <th>Cours Name</th>
                     <th>Module ID</th>
                     <th>Status</th>
                     <th>Action</th>  
            </tr>
           </thead>
       </table>
   </div>


<script>
$(document).ready(function(){


 $('#courses_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ URL::to('/courses-list') }}",
  },
  columns:[
   {
    data: 'id',
    name: 'id'
   },
   {
    data: 'course_name',
    name: 'course_name'
   },
   {
    data: 'module_id',
    name: 'module_id'
   },
   {
    data: 'status',
    name: 'status',
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });



});
</script>
 @endsection('content')