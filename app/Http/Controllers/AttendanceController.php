<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use DataTables;
use Validator;
use Redirect;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Attendance;
use Auth;
use DB;
use PDF;
use QrCode;

class AttendanceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function createAttendanceForm(){
        $courses = DB::table('course')->where('status',1)->get();
        $today = date('m-d-Y');
        return view('attendance.createAttendance',['courses'=>$courses,'today'=>$today]);
    }

    public function store(Request $request){
        $input = $request->all();
          
    //validating attendance form
        $validateInput = Validator::make($input,[
            'course_id'  => 'required|string|',
            //'attendance_date'  => 'required|string',
        ],[
            'course_id.required' => 'Course is required',
           // 'attendance_date.required' => 'Attendance date is required',
        ]);

        if ($validateInput->fails()) {
            \Session::flash('msgErr','Attendance list was not created, try again' );
            return redirect()->back()->withErrors($validateInput->errors())->withInput();
        } 
        else{
            // Making list unique
            $attendance_date = date('m-d-Y'); 
            $uniqueList = DB::table('attendance')
                            ->where('course_id',$input['course_id'])
                            ->where('attendance_date',$attendance_date)
                            ->count();
            if ($uniqueList>0) {
               \Session::flash('msgErr','Attendance list has already been created today for this course');
               return redirect()->back()->withInput();
            }
            else{                
                $attData = array(
                    'course_id' => $input['course_id'],
                    'attendance_date' => $attendance_date,
                    'admin_id'  => Auth::user()->id,
                    'status' =>1,
                );
                $saveAtt = Attendance::create($attData);

               \Session::flash('msg','Today Attendance list successfully created');
               return redirect()->back();
            }        

        }
    }

     public function attendanceCourseForm(){
        $current_date = date('m-d-Y');
        //$courses = DB::table('course')->join('attendance','attendance.course_id','=','course.id')->where('attendance.attendance_date',$current_date)->get();
        $courses = DB::table('course')->where('status',1)->get();

        return view('attendance.attendanceCourseForm',['courses'=>$courses]);
    }

    public function recordAttendance(Request $request){
        $input = $request->all();
        return redirect('record-course-attendance/'.$input['course_id']);
    }

    public function recordCourseAttendance($course_id){
        if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
            $attendance_date = date('m-d-Y'); 
            $uniqueAtt = DB::table('attendance')
                            ->where('course_id',$course_id)
                            ->where('attendance_date',$attendance_date)
                            ->where('student_id', $_GET['student_id'])
                            ->count();
            if ($uniqueAtt>0) {
               \Session::flash('msgErr','Student Attendance has already been recorded for today');
               return redirect()->back();
            }
            else{
            $att = [
                'student_id' => $_GET['student_id'],
                'course_id' => $course_id,
                'student_presence_datetime' => date('m-d-Y H:i:s'),
                'attendance_date' => date('m-d-Y'),
                'admin_id' => Auth::user()->id,
                'status' => 1
            ];
            $saveAtt = Attendance::create($att);
            \Session::flash('msg','Attendance Recorded');
               return redirect()->back();
            }
        }
        if (isset($course_id) && !empty($course_id)) {

            if(request()->ajax()){
                $currenturl = URL::current();
                    $path = explode('/', $currenturl);
        return datatables()->of(Attendance::where('course_id',$path[6])->get())
                ->addColumn('image', function($data){
                    $image = DB::table('student')->where('id',$data->student_id)->get();
                    if (!empty($image[0])) {
                        return $image[0]->image;
                    }
                    
                    })
                ->addColumn('reg_num', function($data){
                    $reg_num = DB::table('student')->where('id',$data->student_id)->get();
                    if (!empty($reg_num[0])) {
                        return $reg_num[0]->reg_num;
                    }
                    
                    })
                ->addColumn('first_name', function($data){
                    $fname = DB::table('student')->where('id',$data->student_id)->get();
                    if(!empty($fname[0])){
                        return $fname[0]->first_name;
                    }
                    })
                ->addColumn('last_name', function($data){
                    $lname = DB::table('student')->where('id',$data->student_id)->get();
                    if (!empty($lname[0])) {
                        return $lname[0]->last_name;  
                    }
                    })
                ->addColumn('course', function($data){
                    $currenturl = URL::current();
                    $path = explode('/', $currenturl);
                    $course = DB::table('course')->where('id',$path[6])->get();
                    if (!empty($course[0])) {
                        return $course[0]->course_name;  
                    }
                    })

                    ->rawColumns(['image','course','reg_num','last_name','first_name'])
                    ->make(true);
            }

        }
        return view('attendance.recordCourseAttendance');
    }
}
