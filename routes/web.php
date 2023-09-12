<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register-student', 'StudentController@getStudentForm')->name('register-student');
Route::get('getDepartments/{faculty}', 'StudentController@getDepartments');
Route::resource('registerStudent', 'StudentController');
Route::get('/students-list', 'StudentController@studentsList')->name('students-list');
Route::get('/print-card/{id}', 'StudentController@printStudentCard');
Route::get('/edit-student/{id}', 'StudentController@editStudent');
Route::post('/update-student/{id}', 'StudentController@updateStudent');
Route::post('/update-student-img/{id}', 'StudentController@updateStudentImg');

Route::get('/add-course', 'CourseController@getCourseForm')->name('add-course');
Route::resource('addCourse', 'CourseController');
Route::get('/courses-list', 'CourseController@coursesList')->name('courses-list');
Route::get('/enroll-student/{id}', 'EnrollmentController@enrollmentForm');
Route::post('enroll', 'EnrollmentController@enrollStudent')->name('enroll');
Route::get('/create-attendance', 'AttendanceController@createAttendanceForm')->name('create-attendance');
Route::resource('createAttendance', 'AttendanceController');
Route::get('/record-attendance', 'AttendanceController@attendanceCourseForm')->name('record-attendance');
Route::post('/recordAttendance', 'AttendanceController@recordAttendance')->name('recordAttendance');
Route::get('record-course-attendance/{course_id}', 'AttendanceController@recordCourseAttendance');









