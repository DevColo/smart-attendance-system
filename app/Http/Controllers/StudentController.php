<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Http\UploadedFile;
use DataTables;
use Validator;
use Redirect;
use App\Models\User;
use App\Models\Enrollment;
use Auth;
use DB;
use PDF;
use QrCode;

class StudentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getStudentForm(){
        return view('student.addStudent');
    }

    public function getDepartments($faculty){
        //CIS
            if ($faculty == 'CIS') {
               $department = [
                       ['value'=> 'Software Engineering','name'=> 'Software Engineering'],
                       ['value'=> 'Networking','name'=> 'Networking'],
                       ['value'=> 'ISM','name'=> 'District ISM'],
               ];
            }
        //Law
            elseif ($faculty == 'Law') {
                $department = [
                       ['value'=> 'Law','name'=> 'Law']
               ];
            }
        //Envirnoment Scinces
            elseif ($faculty == 'Envirnoment Scinces') {
                $department = [
                       ['value'=> 'Envirnoment Management','name'=> 'Envirnoment Management'],
                       ['value'=> 'Disaster Management','name'=> 'District Disaster Management']
               ];
            }
        //Economics Sciences
            elseif ($faculty == 'Economics Sciences') {
                $department = [
                       ['value'=> 'Economics','name'=> 'District Economics'],
                       ['value'=> 'Accounting','name'=> 'Accounting'],
                       ['value'=> 'Marketing','name'=> 'Marketing'],
                       ['value'=> 'Finance','name'=> 'Finance'],
                       ['value'=> 'Human Resourse','name'=> 'Human Resourse'],
               ];
            }
                \Log::info($department);
            //}
           // dd($department);die;
            return response()->json(['data' => $department]);
    }

    public function store(Request $request){
        $input = $request->all();
          
    //validating student form
        $validateInput = Validator::make($input,[
            'fname'  => 'required|string|max:30',
            'lname'  => 'required|string|max:30',
            'gender'  => 'required|string',
            'dob'  => 'required|string',
            'faculty'  => 'required|string',
            'department'  => 'required|string',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'fname.required' => 'First name is required',
            'lname.required' => 'Last name is required',
            'gender.required' => 'Gender name is required',
            'dob.required' => 'Date of birth is required',
            'faculty.required' => 'faculty is required',
            'department.required' => 'Department is required',
        ]);

        if ($validateInput->fails()) {
            \Session::flash('msgErr','Student was not register, try again' );

            return redirect()->back()->withErrors($validateInput->errors())->withInput();
        } 
        else{
            // Making Member unique 
            $uniqueMember = DB::table('student')
                            ->where('first_name',$input['fname'])
                            ->where('last_name',$input['lname'])
                            ->where('dob',$input['dob'])
                            ->count();
            if ($uniqueMember>0) {
               \Session::flash('msgErr','This Student has already been registered ');
               return redirect()->back()->withInput();
            }
            else{
                if(empty($input['reg_num'])){
                    $code = (DB::table('student')->count()) +1;
                    if($code<=9){
                        $reg_num = "00000".$code; 
                    }
                    if($code>9 && $code<=99){
                      $reg_num = "0000".$code; 
                    } 
                    if($code>99 && $code<=999){
                        $reg_num = "000".$code; 
                    }
                    if($code>999 && $code<=9999){
                        $reg_num = "00".$code; 
                    }
                    if($code>9999 && $code<=99999){
                        $reg_num = "0".$code; 
                    }
                    if($code>99999){
                        $reg_num = $code; 
                    }
                }
                else{
                    $reg_num=$input['reg_num'];
                }

                if (empty($input['image'])){
                    $imageName='avatar.jpeg';
                }else{
                     $imageName = time().'.'.$input['image']->extension(); 
                    //$imageName = time().'.'.$input['image'].'jpg';   
                    
                    $input['image']->move(public_path('images'), $imageName);
                }    

                $studentData = array(
                    'first_name' => $input['fname'],
                    'last_name' => $input['lname'],
                    'gender' => $input['gender'],
                    'dob' => $input['dob'],
                    'reg_num' => $reg_num,
                    'image' => $imageName,
                    'faculty' => $input['faculty'],
                    'department' => $input['department'],
                    'admin_id'  => Auth::user()->id,
                    'status' =>1,
                );
                $saveStudent = Student::create($studentData);

               \Session::flash('msg','Student successfully registered');
               return redirect()->back();
            }        

        }
    }

    public function studentsList(){
         
        
    if(request()->ajax()){
        return datatables()->of(Student::latest()->get())
                ->addColumn('action', function($data){
                    $editUrl = url('edit-student/'.$data->id);
                    $printUrl = url('printStudent/'.$data->id);
                    $cardUrl = url('print-card/'.$data->id);
                    $deleteUrl = url('deleteStudent/'.$data->id);
                    $enroll= url('enroll-student/'.$data->id);
                    $csrf = '{{csrf_field()}}';
                        
        $courses = DB::table('course')->leftjoin('enrollment','enrollment.course_id','=','course.id')->where('course.status',1)//->where('enrollment.id',NULL)
         ->get();
        $courses_option = '';
        foreach ($courses as $key => $value){
            if ($value->student_id != $data->id) {
                $courses_option .= '<option value="'.$value->id.'">'.$value->course_name.'</option>';
            }
              
        }
                        $status='fa-trash';
                        $class = 'btn-danger';
                        $btn_text = '';
                       // $enroll = route('enroll');
                        $btn = '<!--<a href="" class="btn-danger delete btn-sm" id="dropId" data-toggle="" data-target=".bs-example-modal-center"><i class="fa fa-trash"></i>'.$btn_text.'</a> -->

<!--<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Available Courses</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="'.route('enroll').'">
                    '.csrf_field().'
                    <div class="form-group">
                    <select class="form-control" name="course_id" required>
                    <option value="" selected disabled>Select Course</option>
                    '.$courses_option.'
                    </select>
                    </div>
                    <div class="form-group">
                    <input type="hidden" value="'.$data->id.'" name="student_id">
                     <button type="submit" class="btn btn-success">Enroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->';
                  
                   $button = '<a href="'.$editUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>';
                        $button .= '&nbsp;';
                        $button .= '<a href="'.$cardUrl.'" data-toggle="tooltip" data-original-title="View"class="delete btn-info btn-sm"><i class="fa fa-camera"></i>Card</a>';
                        $button .= '&nbsp;'; 

                         $button .= '<a href="'.$enroll.'" class="delete btn-warning btn-sm"><i class="fa fa-key"></i>Enroll</a>';
                        $button .= '&nbsp;';
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
            return view('student.studentsList');
        }

    public function printStudentCard($id){
            $student=DB::table('student')->where('id',$id)
           // ->where('status',1)
            ->select('*')->get();
            
            switch ($student[0]->gender) {
                case 'm':
                    $sex = 'Male';
                break;
                case 'f':
                    $sex = 'Female';
                break;
            }

            $data = [
                'image' => $student[0]->image,
                'reg_num' => $student[0]->reg_num,
                'fullname' => $student[0]->first_name.' '.$student[0]->last_name,
                'sex' => $sex,
                'faculty' => $student[0]->faculty,
                'department' => $student[0]->department,
                'qr_code' =>  '?student_id='.$student[0]->id,
                    ];

            return view('student.studentCard',$data);
    }

    public function editStudent(Request $request, $id){
           
        $updateUrl = url('update-student/'.$id);
        $updateMemberImg = url('update-student-img/'.$id);
           
        $data = DB::table('student')
                ->where('id',$id)
                ->select('*')
                ->get();
            
        return view('student.editStudent',['data'=>$data], compact('updateUrl','updateMemberImg'));
    }

    public function updateStudentImg(Request $request, $id){
            $student = Student::findOrFail($id);
            $input =$request->all();

            $imageName = time().'.'.'jpg';  
             
            $input['image']->move(public_path('images'), $imageName);
          // dd($imageName);
            $student->image = $imageName;
            
            $student->admin_id = Auth::user()->id;            
            $student->update();
            
            \Session::flash('msg','Student profile photo successfully updated');
            return redirect()->back();
    }

    public function updateStudent(Request $request, $id){
            $student = Student::findOrFail($id);
        
            $student->reg_num = $request->input('reg_num');
            $student->first_name = $request->input('fname');
            $student->last_name = $request->input('lname');
            $student->gender = $request->input('gender');
            $student->faculty = $request->input('faculty');
            $student->department = $request->input('department');
            $student->dob = $request->input('dob');
            
            $student->admin_id = Auth::user()->id;            
            $student->update();
            
            \Session::flash('msg','Student details successfully updated');
            return redirect()->back();
    }


}
