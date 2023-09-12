@extends('layouts.default')
@section('css')
@endsection('css')
@section('title')
Enroll Student
@endsection('title')
@section('content')
<script src="{!! asset('jquery-3.4.1.js') !!}"></script> 
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form action="{{route('enroll')}}" method="post" enctype="multipart/form-data">
                                                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Available Course<span class="red">*</span></label>
                            <select class="form-control" name="course_id" required>
                                <option value="" selected disabled>Select Course</option>
                                @foreach($courses_option as $course)
                                    <option value="{{ $course['value'] }}">{{ $course['text'] }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('course_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course_id') }}</strong>
                                    </span>
                                @endif
                                                </div>
                            <input type="hidden" name="student_id" value="{{ $student_id }}">
        <button type="submit" class="btn form-control waves-effect waves-light width-md" style="background-color: #035594;border-color: #044b82;">Enroll</button>   
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