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
                            <a class="dt-button buttons-print btn dark btn-outline" style="background-color: #035594;" tabindex="0" aria-controls="sample_1" href="{{route('register-student')}}">
                                <span><i class="fa fa-plus"></i> Register New Student</span>
                            </a>
                        </div>
                    </div>
                </div><br>
    <table class="table table-bordered table-responsive" id="students_table" width="100%" style="display:table;">
           <thead>
            <tr>
                     <th>Image</th>
                     <th>Reg#</th>
                     <th>First Name</th>
                     <th>Last Name</th>
                     <th>Faculty</th>
                     <th>Department</th>
                     <!-- <th>Status</th> -->
                     <th>Action</th>  
            </tr>
           </thead>
       </table>
   </div>

 <!-- <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Reason for deactivation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                    <textarea id="area" class="form-control" name="reason"></textarea>
                    <input type="hidden" name="id" value="">
                    </div>
                    <div class="form-group">
                     <button type="button" name="ok_button" id="ok_button" class="btn btn-success">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->
<!-- delete confirmation modal -->
<!-- <div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5 align="center" style="margin:0;">Are you sure you want to delete this Precint?</h5>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div> -->

<script>
$(document).ready(function(){
//     if( $('#customSwitch1').prop( "checked", false ) ) {
//     alert('Is checked!');
// }

 $('#students_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ URL::to('/students-list') }}",
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
    data: 'faculty',
    name: 'faculty'
   },
   {
    data: 'department',
    name: 'department'
   },
   // {
   //  data: 'status',
   //  name: 'status',
   // },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });

 // var user_id;

 // $(document).on('click', '.delete', function(){
 //  user_id = $(this).attr('id');
 //  $('#confirmModal').modal('show');
 // });

 // $('#ok_button').click(function(){
 //  $.ajax({
 //   url:"home/updateMembers/destroy/"+user_id,
 //   beforeSend:function(){
 //    $('#ok_button').text('Deleting...');
 //   },
 //   success:function(data)
 //   {
 //    setTimeout(function(){
 //     $('#confirmModal').modal('hide');
 //     $('#user_table').DataTable().ajax.reload();
 //    }, 2000);
 //   }
 //  })
 // });

});
</script>
 @endsection('content')