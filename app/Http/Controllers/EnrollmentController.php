<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use DataTables;
use Validator;
use Redirect;
use App\Models\User;
use App\Models\Enrollment;
use Auth;
use DB;

class EnrollmentController extends Controller
{
    public function enrollmentForm($id){
        // $courses = DB::table('course')->leftjoin('enrollment','enrollment.course_id','=','course.id')->where('course.status',1)//->where('enrollment.id',NULL)
        //  ->get();
        //  $courses_option =[];
        // foreach ($courses as $key => $value){
        //     if ($value->student_id != $id) {
        //         if (empty($value->id)) {
        //             $crs = DB::table('course')->where('course_name',$value->course_name)->select('id')->get();
        //             $crs_id = $crs[0]->id;
        //         }else{
        //             $crs_id = $value->id;
        //         }
        //         $courses_option[] = [
        //             'value' => $crs_id,
        //             'text'  => $value->course_name
        //         ];
        //     }
              
        // }
        $courses = DB::table('course')->where('course.status',1)->get();
         $courses_option =[];
        foreach ($courses as $key => $value){
                $courses_option[] = [
                    'value' => $value->id,
                    'text'  => $value->course_name
                ];
              
        }
        $student_id = $id;
        return view('student.enrollStudent',['courses_option'=>$courses_option],compact('student_id'));
    }
        public function enrollStudent(Request $request){
        $input = $request->all();
        // Making enrollment unique 
        $enrollUnique = DB::table('enrollment')
                            ->where('student_id',$input['student_id'])
                            ->where('course_id',$input['course_id'])
                            ->count();
        if ($enrollUnique>0) {
               \Session::flash('msgErr','This student has already enrolled in this course');
               return redirect()->back()->withInput();
        }else{
            $enrollData = [
                'student_id' => $input['student_id'],
                'course_id'  => $input['course_id'],
                'admin_id'   => Auth::user()->id,
                'status'     => 1
            ];
            $saveEnroll = Enrollment::create($enrollData);
            \Session::flash('msg','Student successfully enrolled');
                   return redirect()->back();
        }
    }
}
