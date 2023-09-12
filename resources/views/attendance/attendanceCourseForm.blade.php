@extends('layouts.default')
@section('css')
@endsection('css')
@section('title')
Select the Course
@endsection('title')
@section('content')
<script src="{!! asset('jquery-3.4.1.js') !!}"></script> 
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form action="{{route('recordAttendance')}}" method="post" enctype="multipart/form-data">
                                                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <label>Course<span class="red">*</span></label>
                                <select class="form-control" name="course_id" required>
                                    <option value="" selected disabled>Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{$course->id}}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('course_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course_id') }}</strong>
                                    </span>
                                @endif
                                                </div>
           <div class="form-group">
        <button type="submit" class="btn form-control waves-effect waves-light width-md" style="background-color: #035594;border-color: #044b82;">Next</button>
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


@endsection('script')