@extends('layouts.default')
@section('css')
@endsection('css')
@section('title')
Add Course
@endsection('title')
@section('content')
<script src="{!! asset('jquery-3.4.1.js') !!}"></script> 
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form action="{{route('addCourse.store')}}" method="post" enctype="multipart/form-data">
                                                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                                    <label>Course Name<span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="course" value="{{ old('course') }}" required> 
                                                     @if ($errors->has('course'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course') }}</strong>
                                    </span>
                                @endif
                                                </div>
                                                
                                        </div> <!-- end col -->

                                        <div class="col-md-6 mt-4 mt-md-0">
                       
                                                <div class="form-group">
                                                    <label>Module ID<span class="red"></span></label>
                                                    <input type="text" class="form-control" name="module_id" placeholder="optional">
                                                </div>
                                                <div class="form-group">
        <button type="submit" class="btn form-control waves-effect waves-light width-md" style="background-color: #035594;border-color: #044b82;">Submit</button>
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