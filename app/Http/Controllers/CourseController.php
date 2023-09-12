<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Http\UploadedFile;
use DataTables;
use Validator;
use Redirect;
use App\Models\User;
use Auth;
use DB;
use PDF;
use QrCode;

class CourseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getCourseForm(){
        return view('course.addCourse');
    }

    public function store(Request $request){
        $input = $request->all();
          
    //validating student form
        $validateInput = Validator::make($input,[
            'course'  => 'required|string|max:30',
        ],[
            'course.required' => 'Course is required',
            'course.max' => 'Course name must not exceed 30 characters',
            'course.unique' => 'Course already exist'

        ]);

        if ($validateInput->fails()) {
            \Session::flash('msgErr','The course was not created, try again' );

            return redirect()->back()->withErrors($validateInput->errors())->withInput();
        } 
        else{
            // Making course unique 
            $uniqueCourse = DB::table('course')
                            ->where('course_name',$input['course'])
                            ->count();
            if ($uniqueCourse>0) {
               \Session::flash('msgErr','This Course has already been created ');
               return redirect()->back()->withInput();
            }
            else{
                if(empty($input['module_id'])){
                    $code = (DB::table('course')->count()) +1;
                    if($code<=9){
                        $module_id = "CS00000".$code; 
                    }
                    if($code>9 && $code<=99){
                      $module_id = "CS0000".$code; 
                    } 
                    if($code>99 && $code<=999){
                        $module_id = "CS000".$code; 
                    }
                    if($code>999 && $code<=9999){
                        $module_id = "CS00".$code; 
                    }
                    if($code>9999 && $code<=99999){
                        $module_id = "CS0".$code; 
                    }
                    if($code>99999){
                        $module_id = "CS".$code; 
                    }
                }
                else{
                    $module_id=$input['module_id'];
                }   

                $courseData = array(
                    'course_name' => $input['course'],
                    'module_id' => $module_id,
                    'admin_id'  => Auth::user()->id,
                    'status' =>1,
                );
                $saveCourse = Course::create($courseData);

               \Session::flash('msg','Course successfully created');
               return redirect()->back();
            }        

        }
    }

        public function coursesList(){
    if(request()->ajax()){
        return datatables()->of(Course::latest()->get())
                ->addColumn('action', function($data){
                    $editUrl = url('edit-student/'.$data->id);
                    $printUrl = url('printStudent/'.$data->id);
                    $cardUrl = url('print-card/'.$data->id);
                    $deleteUrl = url('deleteStudent/'.$data->id);
                    $route= url('dropStudent/'.$data->id);
                    $csrf = '{{csrf_field()}}';
                    if ($data->status==1) {
                        $status='fa-trash';
                        $class = 'btn-danger';
                        $btn_text = 'Drop';
                        $statusUrl = url('dropStudent/'.$data->id);
                        $btn = '<a href="'.$statusUrl.'" class="btn-danger delete btn-sm" id="dropId" data-toggle="" data-target=".bs-example-modal-center"><i class="fa fa-trash"></i>'.$btn_text.'</a> 

<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">'.$data->id.'
                <h4 class="modal-title" id="myCenterModalLabel">Reason for deactivation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="'.$statusUrl.'">
                    '.csrf_field().'
                    <div class="form-group">
                    <select class="form-control" name="reason" required>
                    </select>
                    </div>
                    <div class="form-group">
                     <button type="submit" class="btn btn-success">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
                    }else{
                        $status='fa-check';
                        $btn_text = 'Activate';
                        $class = 'btn-success';
                        $statusUrl = url('activeStudent/'.$data->id);
                        $btn= '<a href="'.$statusUrl.'" data-toggle="tooltip" data-original-title="Delete"class="'.$class.' delete btn-sm"><i class="fa '.$status.'"></i>'.$btn_text.'</a>';
                    }
                   $button = '<a href="'.$editUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>';
                        $button .= '&nbsp;'; 

                         $button .=  $btn;
                        return $button;   
                        })
                    ->addColumn('status', function($data){
                    if ($data->status==1) {
                        $status='active';
                        $class = 'btn-success';
                    }else{
                        $status='dropped';
                        $class = 'btn-danger';
                    }

                    return '<a href="#" class="'.$class.' white-text delete btn-sm">'.$status.'</a>';  
                    })

                    ->rawColumns(['action','status'])
                    ->make(true);
            }
            return view('course.coursesList');
        }
}
