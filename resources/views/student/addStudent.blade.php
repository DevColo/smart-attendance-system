@extends('layouts.default')
@section('css')
@endsection('css')
@section('title')
Add Student
@endsection('title')
@section('content')
<script src="{!! asset('jquery-3.4.1.js') !!}"></script> 
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <p class="sub-header text-white text-center" style="background:#35b8e0;">BIO DATA INFORMATION</p>
            <form action="{{route('registerStudent.store')}}" method="post" enctype="multipart/form-data" id="addMember">
                                                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                                    <label>Fisrt Name<span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="fname" value="{{ old('fname') }}" required> 
                                                     @if ($errors->has('fname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif
                                                </div>

                                               <div class="form-group">
                                                    <label>Last Name<span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="lname" value="{{ old('lname') }}" required>
                                                     @if ($errors->has('lname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif
                                                </div>
                                    <div class="form-group">
                                        <label>Gender<span class="red">*</span></label>
                                        <select class="form-control" name="gender" required> <option value="{{ old('gender') }}">- Select Gender - {{ old('gender') }}</option>

                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                         @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                                    </div>
                                                
                            
                                 
                                     
                                     
        
                                        </div> <!-- end col -->

                                        <div class="col-md-6 mt-4 mt-md-0">
                       <div class="form-group">
                                                   <label>Date of Birth<span class="red">*</span></label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" name="dob" value="{{old('dob')}}" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                    @if ($errors->has('DOB'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('DOB') }}</strong>
                                    </span>
                                @endif
                                                </div>

                                    <div class="form-group">
                                                    <label>Upload Student Photo<span class="red"></span></label>
                                                    <input type="file" class="form-control" accept="image/*" name="image" value="null">
                                                     @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Registration Number<span class="red"></span></label>
                                                    <input type="text" class="form-control" name="reg_num" placeholder="optional">
                                                </div><br>
                                            
                                        </div> <!-- end col -->
                                    </div>
<p class="sub-header text-white text-center" style="background:#35b8e0;">SCHOOL INFORMATION</p>
                                    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                                        <label>Faculty<span class="red">*</span></label>
                        <select class="form-control" name="faculty" value="{{old('faculty')}}" id="faculty" required>
                        <option value="{{old('faculty')}}">- Select Faculty - {{old('faculty')}}</option>
                        <option value="CIS">CIS</option>
                        <option value="Law">Law</option>
                        <option value="Envirnoment Scinces">Envirnoment Scinces</option>
                        <option value="Economics Sciences">Economics Sciences</option>
                                        </select>
                                         @if ($errors->has('faculty'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty') }}</strong>
                                    </span>
                                @endif
                                    </div>    
        </div> <!-- end col -->

        <div class="col-md-6 mt-4 mt-md-0">      
          <div class="form-group">
                <label>Department<span class="red">*</span></label>
                <select class="form-control" name="department" id="department" required>
                    <option value="{{old('department')}}">Department {{old('department')}}</option>
                </select>
                @if ($errors->has('department'))
                    <span class="help-block">
                        <strong>{{ $errors->first('department') }}</strong>
                    </span>
                @endif
            </div>     
        <br>
        <div class="form-group">
        <button type="submit" class="btn form-control waves-effect waves-light width-md" style="background-color: #035594;border-color: #044b82;">Register</button>
    </div>
                                            
                                        </div> <!-- end col -->
                                    </div>
</form>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div>
                        <!-- Default checked -->

@endsection('content')

@section('script')
 <!-- Mask input -->
<script src="{{asset('assets/libs/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {       
    $("select#faculty").change(function () {
        var faculty = $(this).val();
        $('#department').find('option').not(':first').remove();
         $.ajax({
            url: "{{ URL::to('/getDepartments') }}/"+faculty,
            type: 'GET',
            //data: {faculty: faculty_id},
            dataType: 'json',
            success:function (response) {
                    var len = 0;
                    if (response.data != null) {
                        len = response.data.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.data[i].value;
                             var name = response.data[i].name;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#department").append(option);
                        }
                    }
                }
        });
    });
});
</script>

@endsection('script')